<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Services\MidtransService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    protected MidtransService $midtrans;
    protected StockService $stock;

    public function __construct(MidtransService $midtrans, StockService $stock)
    {
        $this->midtrans = $midtrans;
        $this->stock    = $stock;
    }

    // ---------------------------------------------------------------
    // Halaman checkout (tampilkan form)
    // ---------------------------------------------------------------
    public function checkout()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('checked', true)
            ->with('produk')
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Pilih minimal 1 produk untuk checkout!');
        }

        $subtotal = $keranjang->sum(fn($i) => $i->produk->harga * $i->jumlah);
        $ongkir   = $subtotal < 200000 ? 15000 : 0;
        $total    = $subtotal + $ongkir;

        return view('transaksi.checkout', compact('keranjang', 'subtotal', 'ongkir', 'total'));
    }

    // ---------------------------------------------------------------
    // Proses checkout — simpan transaksi, BELUM kurangi stok
    // ---------------------------------------------------------------
public function store(Request $request)
{
    \Log::info('=== CHECKOUT MULAI ===');

    // ============================================
    // 1. VALIDASI
    // ============================================
    $validator = \Validator::make($request->all(), [
        'nama_pembeli'      => 'required|string|max:100',
        'alamat'            => 'required|string',
        'nomor_wa'          => 'required|string|max:20',
        'metode_pembayaran' => 'required|in:QRIS,COD,VA,CC',
        'destination_id'    => 'required|numeric',
        'kurir'             => 'required|string|max:20',
        'layanan_kurir'     => 'required|string|max:50',
        'ongkir'            => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        if ($request->ajax()) {
            return response()->json(['message' => 'Data tidak lengkap.', 'errors' => $validator->errors()], 422);
        }
        return redirect()->back()->withErrors($validator)->withInput();
    }
    \Log::info('1. Validasi LOLOS');

    // ============================================
    // 2. CEK KERANJANG
    // ============================================
    $keranjang = Keranjang::where('user_id', Auth::id())
        ->where('checked', true)
        ->with('produk')
        ->get();

    if ($keranjang->isEmpty()) {
        $msg = 'Pilih minimal 1 produk untuk checkout!';
        if ($request->ajax()) { return response()->json(['message' => $msg], 400); }
        return redirect()->route('keranjang.index')->with('error', $msg);
    }
    \Log::info('2. Keranjang ada: ' . $keranjang->count() . ' item');

    // ============================================
    // 3. VALIDASI STOK
    // ============================================
    $stockError = $this->stock->validateStock($keranjang);
    if ($stockError) {
        if ($request->ajax()) { return response()->json(['message' => $stockError], 400); }
        return redirect()->route('keranjang.index')->with('error', $stockError);
    }
    \Log::info('3. Stok mencukupi');

    // ============================================
    // 4. HITUNG TOTAL
    // ============================================
    $subtotal = $keranjang->sum(fn($i) => $i->produk->harga * $i->jumlah);
    $ongkir   = (int) $request->ongkir;
    $total    = $subtotal + $ongkir;
    \Log::info('4. Total dihitung: ' . $total);

    // ============================================
    // 5. SIMPAN TRANSAKSI KE DB
    // ============================================
    \Log::info('5. MASUK DB::TRANSACTION');
    $transaksi = DB::transaction(function () use ($request, $total, $ongkir, $keranjang) {
        $t = Transaksi::create([
            'user_id'           => Auth::id(),
            'order_id'          => 'ORDER-' . strtoupper(Str::random(8)) . '-' . time(),
            'total_harga'       => $total,
            'ongkir'            => $ongkir,
            'metode_pembayaran' => $request->metode_pembayaran,
            'nama_pembeli'      => $request->nama_pembeli,
            'alamat'            => $request->alamat,
            'nomor_wa'          => $request->nomor_wa,
            'catatan'           => $request->catatan,
            'province_id'       => $request->province_id,
            'city_id'           => $request->city_id,
            'city_name'         => $request->city_name,
            'kurir'             => $request->kurir,
            'layanan_kurir'     => $request->layanan_kurir,
            'estimasi'          => $request->estimasi,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'status'            => Transaksi::STATUS_PENDING,
            'stock_reduced'     => false,
        ]);
        \Log::info('5a. Transaksi create ID: ' . $t->id);

        foreach ($keranjang as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $t->id,
                'produk_id'    => $item->produk_id,
                'nama_produk'  => $item->produk->nama,
                'harga'        => $item->produk->harga,
                'jumlah'       => $item->jumlah,
                'subtotal'     => $item->produk->harga * $item->jumlah,
            ]);
        }
        \Log::info('5b. Detail transaksi disimpan');

        Keranjang::where('user_id', Auth::id())
            ->where('checked', true)
            ->delete();
        \Log::info('5c. Keranjang dihapus');

        return $t;
    });
    \Log::info('6. DB::TRANSACTION SELESAI');

    // ============================================
    // 6. COD — langsung selesai
    // ============================================
    if ($request->metode_pembayaran === 'COD') {
        \Log::info('7. MASUK BLOK COD');
        $this->stock->decreaseStock($transaksi);
        \Log::info('8. Stok dikurangi');

        $transaksi->update([
            'status'        => Transaksi::STATUS_COD_PENDING,
            'stock_reduced' => true,
        ]);
        \Log::info('9. Status diupdate');

        $redirectUrl = route('transaksi.success', $transaksi->id);

        if ($request->ajax()) {
            \Log::info('10. RETURN JSON');
            return response()->json([
                'message'  => 'Pesanan COD berhasil dibuat!',
                'redirect' => $redirectUrl,
            ]);
        }

        return redirect()->route('transaksi.success', $transaksi->id)
            ->with('success', 'Pesanan COD berhasil dibuat!');
    }

    // ... sisanya tetap ...
    // ============================================
    // 7. QRIS / VA / CC — Midtrans Snap Token
    // ============================================
    \Log::info('MULAI buat snap token', ['order_id' => $transaksi->order_id]);

    try {
        $params    = $this->midtrans->buildParams($transaksi, Auth::user());

        // TAMBAHAN PENTING: timeout supaya tidak hang selamanya
        $snapToken = $this->midtrans->createSnapToken($params);

        \Log::info('Snap token OK', ['order_id' => $transaksi->order_id]);

        $transaksi->update(['snap_token' => $snapToken]);

        // ---- PERUBAHAN UTAMA: return JSON, bukan view() ----
        if ($request->ajax()) {
            return response()->json([
                'message'    => 'Pesanan dibuat, mengarahkan ke pembayaran...',
                'redirect'   => route('transaksi.payment', $transaksi->id),
                'snap_token' => $snapToken,
            ]);
        }

        // Request biasa (bukan AJAX) — tetap return view seperti dulu
        return view('transaksi.checkout_payment', compact('snapToken', 'transaksi'));

    } catch (\Exception $e) {
        \Log::error('Midtrans GAGAL', [
            'order_id' => $transaksi->order_id,
            'error'    => $e->getMessage(),
            'trace'    => $e->getTraceAsString(),
        ]);

        $transaksi->update(['status' => Transaksi::STATUS_CANCELLED]);

        // AJAX: return JSON error yang jelas
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Gagal menghubungi payment gateway. Silakan coba lagi. (' . $e->getMessage() . ')'
            ], 500);
        }

        // Request biasa: redirect seperti dulu
        return redirect()->route('keranjang.index')
            ->with('error', 'Gagal menghubungi payment gateway: ' . $e->getMessage());
    }
}

    // ---------------------------------------------------------------
    // Halaman sukses
    // ---------------------------------------------------------------
    public function success($id = null)
    {
        $transaksi = $id
            ? Transaksi::where('user_id', Auth::id())->findOrFail($id)
            : null;

        return view('transaksi.success', compact('transaksi'));
    }

    // ---------------------------------------------------------------
    // Riwayat transaksi user
    // ---------------------------------------------------------------
    public function riwayat()
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->with('details')
            ->latest()
            ->paginate(10);

        // Menghitung statistik pesanan
        $semua = Transaksi::where('user_id', Auth::id())->count();
        $menunggu = Transaksi::where('user_id', Auth::id())->where('status', 'pending')->count();
        $selesai = Transaksi::where('user_id', Auth::id())->where('status', 'completed')->count();
        $batal = Transaksi::where('user_id', Auth::id())->where('status', 'cancelled')->count();

        return view('transaksi.riwayat', compact('transaksi', 'semua', 'menunggu', 'selesai', 'batal'));
    }

    public function received($id)
{
    $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);

    if ($transaksi->status !== 'shipped') {
        return back()->with('error', 'Status pesanan tidak valid.');
    }

    $transaksi->update(['status' => Transaksi::STATUS_COMPLETED]);

    return back()->with('success', 'Pesanan dikonfirmasi diterima. Terima kasih!');
}

    // ---------------------------------------------------------------
    // Detail satu transaksi
    // ---------------------------------------------------------------
    public function show($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->with('details.produk')
            ->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }

    // ---------------------------------------------------------------
    // User batalkan transaksi (hanya kalau masih pending)
    // ---------------------------------------------------------------
    public function cancel($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);

        if ($transaksi->status !== Transaksi::STATUS_PENDING) {
            return back()->with('error', 'Transaksi tidak bisa dibatalkan.');
        }

        $transaksi->update(['status' => Transaksi::STATUS_CANCELLED]);

        return back()->with('success', 'Transaksi berhasil dibatalkan.');
    }
}
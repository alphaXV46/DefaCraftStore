@extends('layouts.app')

@section('title', 'Kontak Kami - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-2" style="color: #4A3F5C;">Kontak Kami</h2>
                    <p class="text-muted mb-4">Ada pertanyaan? Kami siap membantu Anda kapan saja.</p>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <div style="font-size: 2rem;">📍</div>
                                <h6 class="fw-bold mt-2 mb-1">Lokasi</h6>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Bogor, Jawa Barat, Indonesia</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <div style="font-size: 2rem;">📧</div>
                                <h6 class="fw-bold mt-2 mb-1">Email</h6>
                                <a href="mailto:dendyfadhlullah46@gmail.com" class="text-muted text-decoration-none" style="font-size: 0.9rem; word-break: break-all;">dendyfadhlullah46@gmail.com</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <div style="font-size: 2rem;">📱</div>
                                <h6 class="fw-bold mt-2 mb-1">WhatsApp</h6>
                                <a href="https://wa.me/6285658080575" target="_blank" class="text-muted text-decoration-none" style="font-size: 0.9rem;">+62 856-5808-0575</a>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 mb-4" style="background: #f8f9fa;">
                        <p class="mb-1 fw-bold" style="font-size: 0.9rem;">⏰ Jam Operasional</p>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Senin – Sabtu, pukul 08.00 – 17.00 WIB</p>
                    </div>

                    <a href="https://wa.me/6285658080575" target="_blank"
                       class="btn btn-success d-inline-flex align-items-center gap-2 px-4 py-2 fw-bold rounded-pill">
                        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

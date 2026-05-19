@extends('layouts.app')

@section('title', 'FAQ - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-4" style="color: #4A3F5C;">Frequently Asked Questions (FAQ)</h2>
                    
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3 rounded shadow-sm">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-bold collapsed bg-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Apakah produk yang dijual 100% original?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Ya, seluruh produk Blind Box, Figure, dan Art Toys di DefaCraftStore dijamin 100% original dan bersumber dari distributor/desainer terpercaya untuk melengkapi koleksi estetik Anda.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3 rounded shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button fw-bold collapsed bg-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Bagaimana jika saya terlambat membayar pesanan?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Setiap invoice Midtrans memiliki batas kedaluwarsa 24 jam. Jika Anda melewati batas tersebut, sistem akan otomatis membatalkan pesanan (Expired). Anda dipersilakan melakukan proses checkout ulang jika masih ingin membeli.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3 rounded shadow-sm">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button fw-bold collapsed bg-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Apakah saya bisa melakukan Pre-Order untuk seri langka?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Tentu saja! Jika ada seri Blind Box atau Action Figure langka/tertentu yang tidak ada di katalog, Anda bisa langsung menghubungi kami melalui WhatsApp atau email yang tertera di halaman Kontak Kami untuk request pencarian unit/pre-order khusus.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 rounded shadow-sm">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button fw-bold collapsed bg-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Apakah melayani pengiriman ke luar Indonesia?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Saat ini, kami hanya melayani pengiriman domestik (seluruh Indonesia) karena kami menggunakan integrasi logistik lokal (RajaOngkir).
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

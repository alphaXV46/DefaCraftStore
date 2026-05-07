@extends('layouts.app')

@section('title', $produk->nama . ' - DefaCraftStore')

@push('styles')
<style>
    /* ============================================
       PRODUCT DETAIL — VERTICAL + WHITE CONTAINER
       Pure CSS Makeover ✿
       ============================================ */

    /* === PAGE === */
    .product-detail-page {
        background: linear-gradient(180deg, #FFFDF7 0%, #FFD6E0 30%, #FFF4B8 60%, #E9DFFF 100%) !important;
        background-attachment: fixed !important;
        min-height: 100vh !important;
        padding: 2rem 0 0 !important;
        position: relative !important;
        overflow-x: hidden !important;
    }

    .product-detail-page::before {
        content: '' !important;
        position: absolute !important;
        top: -50% !important;
        left: -50% !important;
        width: 200% !important;
        height: 200% !important;
        background: radial-gradient(circle, rgba(255, 143, 171, 0.05) 0%, transparent 60%) !important;
        animation: pdRotate 25s linear infinite !important;
        z-index: -1 !important;
    }

    @keyframes pdRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .product-container {
        max-width: 860px !important;
        margin: 0 auto !important;
        padding: 0 1.25rem !important;
    }

    /* =============================================
       KILL CARD — beat custom.css !important
       ============================================= */
    .product-detail-page .product-card {
        background: transparent !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        border: none !important;
        overflow: visible !important;
        height: auto !important;
        display: block !important;
        flex-direction: unset !important;
        position: relative !important;
        z-index: 2 !important;
        transition: none !important;
        padding: 0 !important;
    }

    .product-detail-page .product-card::before {
        display: none !important;
    }

    /* =============================================
       WHITE CONTAINER — product-content jadi card
       (Membungkus gambar + info dalam satu box)
       ============================================= */
    .product-detail-page .product-content {
        display: flex !important;
        flex-direction: column !important;
        gap: 0 !important;
        padding: 0 !important;
        width: 100% !important;

        /* Ini yang bikin jadi satu wadah putih */
        background: #FFFFFF !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-radius: var(--radius-2xl) !important;
        border: 1px solid rgba(255, 214, 224, 0.2) !important;
        box-shadow:
            0 20px 50px -12px rgba(255, 143, 171, 0.1),
            0 8px 20px -8px rgba(255, 209, 102, 0.08) !important;
        overflow: hidden !important;
    }

    /* =============================================
       IMAGE SECTION — di dalam white container
       ============================================= */
    .product-detail-page .image-section {
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: linear-gradient(135deg,
            rgba(255, 244, 184, 0.12) 0%,
            rgba(255, 214, 224, 0.1) 50%,
            rgba(233, 223, 255, 0.08) 100%
        ) !important;
        border-radius: 0 !important;
        padding: 2.5rem 2rem !important;
        min-height: 380px !important;
        border: none !important;
        border-bottom: 1px solid rgba(255, 214, 224, 0.12) !important;
        margin-bottom: 0 !important;
    }

    /* Blob dekoratif di dalam container */
    .product-detail-page .image-section::before {
        content: '' !important;
        position: absolute !important;
        width: 70% !important;
        height: 75% !important;
        background: linear-gradient(135deg,
            rgba(255, 214, 224, 0.2) 0%,
            rgba(255, 244, 184, 0.15) 50%,
            rgba(233, 223, 255, 0.1) 100%
        ) !important;
        border-radius: 50% 45% 55% 48% / 48% 55% 45% 52% !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        z-index: 0 !important;
        animation: blobMove 8s ease-in-out infinite !important;
        filter: blur(2px) !important;
    }

    @keyframes blobMove {
        0%, 100% { border-radius: 50% 45% 55% 48% / 48% 55% 45% 52%; transform: translate(-50%, -50%) scale(1); }
        50% { border-radius: 48% 55% 45% 52% / 52% 48% 55% 45%; transform: translate(-50%, -52%) scale(1.04); }
    }

    .product-detail-page .image-section::after {
        content: '' !important;
        position: absolute !important;
        width: 40% !important;
        height: 45% !important;
        background: linear-gradient(135deg, rgba(255, 244, 184, 0.12), rgba(196, 181, 253, 0.08)) !important;
        border-radius: 55% 45% 50% 50% / 50% 55% 45% 55% !important;
        top: 40% !important;
        left: 62% !important;
        transform: translate(-50%, -50%) !important;
        z-index: 0 !important;
        animation: blobMove 11s ease-in-out infinite reverse !important;
        filter: blur(3px) !important;
    }

    /* Gambar produk */
    .product-detail-page .product-image {
        position: relative !important;
        z-index: 1 !important;
        width: 100% !important;
        max-width: 320px !important;
        height: 320px !important;
        object-fit: contain !important;
        border-radius: var(--radius-xl) !important;
        box-shadow: 0 20px 40px -10px rgba(255, 143, 171, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.6) !important;
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        border: none !important;
        transform: rotate(-2deg) translateY(4px) !important;
        background: rgba(255, 255, 255, 0.5) !important;
        padding: 1.25rem !important;
    }

    .product-detail-page .product-card:hover .product-image {
        transform: rotate(0deg) translateY(0) scale(1.03) !important;
    }

    .product-detail-page .placeholder-image {
        position: relative !important;
        z-index: 1 !important;
        width: 100% !important;
        max-width: 320px !important;
        height: 320px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: rgba(255, 244, 184, 0.15) !important;
        border-radius: var(--radius-xl) !important;
        border: none !important;
        box-shadow: 0 20px 40px -10px rgba(255, 143, 171, 0.08) !important;
        transform: rotate(-2deg) translateY(4px) !important;
    }

    .product-detail-page .placeholder-icon {
        font-size: 4.5rem !important;
        filter: drop-shadow(0 4px 8px rgba(255, 143, 171, 0.08)) !important;
    }

    /* =============================================
       INFO SECTION — di dalam white container
       ============================================= */
    .product-detail-page .info-section {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 0 !important;
        padding: 1.75rem 1.75rem 2rem !important;
        align-content: start !important;
        flex-direction: unset !important;
        justify-content: unset !important;
    }

    /* --- REORDER VISUAL ---
       1. Back
       2. Category
       3. Title
       4. Price
       5. Stock
       6. Form (CTA strategis)
       7. Description (bawah)
    */

    .product-detail-page .back-button {
        order: -10 !important;
        background: transparent !important;
        color: #CCCCCC !important;
        border: 1.5px solid rgba(0, 0, 0, 0.06) !important;
        border-radius: var(--radius-full) !important;
        padding: 0.4rem 0.9rem !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        font-size: 0.78rem !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.3rem !important;
        box-shadow: none !important;
        width: fit-content !important;
        margin-bottom: 1rem !important;
    }

    .product-detail-page .back-button:hover {
        background: var(--gradient-primary) !important;
        color: #FFFFFF !important;
        border-color: transparent !important;
        transform: translateX(-3px) !important;
        box-shadow: 0 4px 12px rgba(255, 143, 171, 0.2) !important;
    }

    .product-detail-page .product-category {
        order: -9 !important;
        background: var(--gradient-primary) !important;
        color: white !important;
        padding: 0.28rem 0.9rem !important;
        border-radius: var(--radius-full) !important;
        font-weight: 700 !important;
        font-size: 0.65rem !important;
        display: inline-block !important;
        width: fit-content !important;
        margin-bottom: 0.7rem !important;
        box-shadow: 0 3px 10px rgba(255, 143, 171, 0.18) !important;
        letter-spacing: 1px !important;
        text-transform: uppercase !important;
    }

    .product-detail-page .product-title {
        order: -8 !important;
        font-size: 1.85rem !important;
        font-weight: 800 !important;
        color: #333333 !important;
        margin-bottom: 0.75rem !important;
        line-height: 1.2 !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        letter-spacing: -0.3px !important;
    }

    .product-detail-page .product-price {
        order: -7 !important;
        font-size: 1.85rem !important;
        font-weight: 900 !important;
        color: var(--primary) !important;
        margin-bottom: 1rem !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* Stock */
    .product-detail-page .stock-info {
        order: -6 !important;
        margin-bottom: 1.25rem !important;
        padding: 0.55rem 0.8rem !important;
        background: rgba(255, 244, 184, 0.12) !important;
        border-radius: var(--radius-lg) !important;
        border-left: 3px solid var(--secondary) !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        flex-wrap: wrap !important;
    }

    .product-detail-page .stock-label {
        color: #CCCCCC !important;
        font-weight: 600 !important;
        margin-bottom: 0 !important;
        font-size: 0.78rem !important;
    }

    .product-detail-page .stock-badge {
        padding: 0.22rem 0.7rem !important;
        border-radius: var(--radius-full) !important;
        font-weight: 700 !important;
        font-size: 0.73rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.3rem !important;
    }

    .product-detail-page .stock-available {
        background: rgba(126, 203, 161, 0.15) !important;
        color: #2D6A4F !important;
        border: 1px solid rgba(126, 203, 161, 0.25) !important;
    }

    .product-detail-page .stock-limited {
        background: rgba(255, 209, 102, 0.15) !important;
        color: #7A6200 !important;
        border: 1px solid rgba(255, 209, 102, 0.25) !important;
    }

    .product-detail-page .stock-out {
        background: rgba(255, 107, 138, 0.12) !important;
        color: #9B2335 !important;
        border: 1px solid rgba(255, 107, 138, 0.25) !important;
    }

    /* Form — CTA */
    .product-detail-page .form-section {
        order: -5 !important;
        margin-bottom: 0 !important;
    }

    .product-detail-page .form-section > form,
    .product-detail-page .form-section > .alert-custom {
        background: rgba(255, 244, 184, 0.06) !important;
        backdrop-filter: none !important;
        border-radius: var(--radius-xl) !important;
        border: 1px solid rgba(255, 214, 224, 0.1) !important;
        box-shadow: none !important;
        padding: 1.15rem !important;
    }

    .product-detail-page .form-label {
        color: #CCCCCC !important;
        font-weight: 600 !important;
        margin-bottom: 0.4rem !important;
        font-size: 0.7rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        display: block !important;
    }

    .product-detail-page .quantity-input {
        background: #FFFFFF !important;
        border: 1.5px solid rgba(255, 214, 224, 0.25) !important;
        border-radius: var(--radius-lg) !important;
        padding: 0.6rem 1rem !important;
        color: #333333 !important;
        font-size: 1rem !important;
        width: 100% !important;
        transition: all 0.3s ease !important;
        box-shadow: none !important;
    }

    .product-detail-page .quantity-input:focus {
        outline: none !important;
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(255, 143, 171, 0.08) !important;
    }

    .product-detail-page .cart-button {
        background: var(--gradient-primary) !important;
        color: white !important;
        border: none !important;
        border-radius: var(--radius-full) !important;
        padding: 0.8rem 2rem !important;
        font-weight: 700 !important;
        font-size: 0.92rem !important;
        width: 100% !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 6px 20px rgba(255, 143, 171, 0.22) !important;
        cursor: pointer !important;
        position: relative !important;
        overflow: hidden !important;
        margin-top: 0.75rem !important;
        display: block !important;
    }

    .product-detail-page .cart-button::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: -100% !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent) !important;
        transition: left 0.5s ease !important;
    }

    .product-detail-page .cart-button:hover::before {
        left: 100% !important;
    }

    .product-detail-page .cart-button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 28px rgba(255, 143, 171, 0.28) !important;
    }

    .product-detail-page .cart-button:disabled {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Alerts */
    .product-detail-page .alert-custom {
        background: rgba(135, 206, 235, 0.06) !important;
        border: 1px solid rgba(135, 206, 235, 0.15) !important;
        border-radius: var(--radius-lg) !important;
        padding: 1rem !important;
        color: #1B6B93 !important;
        margin-bottom: 0 !important;
        backdrop-filter: none !important;
        box-shadow: none !important;
    }

    .product-detail-page .alert-info-custom {
        background: rgba(135, 206, 235, 0.06) !important;
        border-color: rgba(135, 206, 235, 0.15) !important;
        border-left: 3px solid var(--info) !important;
        color: #1B6B93 !important;
    }

    .product-detail-page .alert-danger-custom {
        background: rgba(255, 107, 138, 0.05) !important;
        border-color: rgba(255, 107, 138, 0.15) !important;
        border-left: 3px solid var(--danger) !important;
        color: #9B2335 !important;
    }

    /* Description — paling bawah, separator halus */
    .product-detail-page .description-section {
        order: 99 !important;
        margin: 1.25rem 0 0 !important;
        padding: 1.25rem !important;
        background: rgba(0, 0, 0, 0.015) !important;
        backdrop-filter: none !important;
        border-radius: var(--radius-xl) !important;
        border: none !important;
        border-top: 1px dashed rgba(255, 214, 224, 0.25) !important;
        box-shadow: none !important;
    }

    .product-detail-page .description-section::before {
        display: none !important;
    }

    .product-detail-page .description-title {
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        color: #CCCCCC !important;
        margin-bottom: 0.4rem !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
    }

    .product-detail-page .description-text {
        color: #AAAAAA !important;
        line-height: 1.75 !important;
        font-size: 0.9rem !important;
    }

    /* =============================================
       RELATED PRODUCTS
       ============================================= */
    .product-detail-page .related-products-section {
        margin-top: 2.5rem !important;
        position: relative !important;
        z-index: 2 !important;
        padding-bottom: 2rem !important;
    }

    .product-detail-page .section-title {
        font-size: 1.25rem !important;
        font-weight: 800 !important;
        color: #333333 !important;
        margin-bottom: 1.25rem !important;
        text-align: left !important;
        position: relative !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        padding-left: 1rem !important;
        border-left: 3px solid var(--primary) !important;
    }

    .product-detail-page .section-title::after {
        display: none !important;
    }

    /* ROW → Grid */
    .product-detail-page .related-products-section .row {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 1rem !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        flex-wrap: unset !important;
    }

    /* COL → reset Bootstrap */
    .product-detail-page .related-products-section .row > [class*="col-"] {
        flex: none !important;
        max-width: none !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        display: block !important;
    }

    /* Related Card */
    .product-detail-page .related-product-card {
        background: #FFFFFF !important;
        border-radius: var(--radius-2xl) !important;
        overflow: visible !important;
        box-shadow: 0 8px 24px -6px rgba(255, 143, 171, 0.08), 0 4px 10px -4px rgba(255, 209, 102, 0.06) !important;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        height: 100% !important;
        border: 1px solid rgba(255, 214, 224, 0.15) !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .product-detail-page .related-product-card:hover {
        transform: translateY(-5px) scale(1.02) !important;
        box-shadow: 0 20px 40px -8px rgba(255, 143, 171, 0.15) !important;
        border-color: rgba(255, 143, 171, 0.25) !important;
    }

    .product-detail-page .related-product-image-wrapper {
        position: relative !important;
        overflow: hidden !important;
        height: 170px !important;
        background: linear-gradient(135deg, #FFF9EC, #FFD6E0) !important;
        border-radius: var(--radius-2xl) var(--radius-2xl) 0 0 !important;
    }

    .product-detail-page .related-product-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.5s ease !important;
        border-bottom: none !important;
    }

    .product-detail-page .related-product-card:hover .related-product-image {
        transform: scale(1.08) !important;
    }

    .product-detail-page .related-product-placeholder {
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: rgba(255, 143, 171, 0.18) !important;
    }

    .product-detail-page .related-product-info {
        padding: 1rem !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
    }

    .product-detail-page .related-product-name {
        font-weight: 700 !important;
        font-size: 0.85rem !important;
        color: #333333 !important;
        margin-bottom: 0.3rem !important;
        transition: color 0.3s ease !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        line-height: 1.35 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
    }

    .product-detail-page .related-product-card:hover .related-product-name {
        color: var(--primary) !important;
    }

    .product-detail-page .related-product-price {
        font-size: 1rem !important;
        font-weight: 800 !important;
        color: var(--primary) !important;
        margin-bottom: 0.65rem !important;
    }

    .product-detail-page .related-product-button {
        background: transparent !important;
        color: #CCCCCC !important;
        border: 1.5px solid rgba(0, 0, 0, 0.06) !important;
        border-radius: var(--radius-full) !important;
        padding: 0.45rem 0.8rem !important;
        width: 100% !important;
        transition: all 0.3s ease !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        font-size: 0.75rem !important;
        text-align: center !important;
        display: block !important;
        text-decoration: none !important;
        margin-top: auto !important;
    }

    .product-detail-page .related-product-button:hover {
        background: var(--gradient-primary) !important;
        color: #FFFFFF !important;
        border-color: transparent !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 5px 14px rgba(255, 143, 171, 0.2) !important;
    }

    /* Empty state */
    .product-detail-page .related-products-section .text-center {
        grid-column: 1 / -1 !important;
        padding: 2rem 0 !important;
    }
    /* === OVERRIDE: White BG + Image Cover + No Pink === */
.product-detail-page {
    background: #F5F5F7 !important;
    background-image: none !important;
    background-attachment: scroll !important;
}
.product-detail-page::before { display: none !important; }

.product-detail-page .product-content {
    border-color: rgba(0,0,0,0.06) !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06) !important;
}

.product-detail-page .image-section {
    background: #F9F9F9 !important;
    background-image: none !important;
    aspect-ratio: 4/3 !important;
    max-height: 450px !important;
    overflow: hidden !important;
    cursor: zoom-in !important;
}
.product-detail-page .image-section::before,
.product-detail-page .image-section::after {
    display: none !important;
}
.product-detail-page .product-image {
    width: 100% !important;
    height: 100% !important;
    max-width: none !important;
    object-fit: cover !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    transform: none !important;
    background: #F9F9F9 !important;
    padding: 0 !important;
}
.product-detail-page .product-card:hover .product-image {
    transform: scale(1.03) !important;
}
.product-detail-page .placeholder-image {
    width: 100% !important;
    height: 100% !important;
    max-width: none !important;
    background: #F9F9F9 !important;
    transform: none !important;
    box-shadow: none !important;
}

/* Zoom hint badge */
.pd-zoom-hint {
    position: absolute !important;
    bottom: 12px !important;
    right: 12px !important;
    background: rgba(0,0,0,0.5) !important;
    color: #fff !important;
    font-size: 0.7rem !important;
    font-weight: 600 !important;
    padding: 0.25rem 0.6rem !important;
    border-radius: 50px !important;
    z-index: 2 !important;
    pointer-events: none !important;
}

/* Hapus pink di detail */
.product-detail-page .back-button:hover {
    background: linear-gradient(135deg, #FEF9C3, #EAB308) !important;
    box-shadow: 0 4px 12px rgba(234,179,8,0.2) !important;
}
.product-detail-page .product-category {
    background: linear-gradient(135deg, #FEF9C3, #EAB308) !important;
    box-shadow: 0 3px 10px rgba(234,179,8,0.18) !important;
}
.product-detail-page .stock-info {
    background: #FFFBEB !important;
    border-left-color: #EAB308 !important;
}
.product-detail-page .stock-limited {
    background: rgba(234,179,8,0.12) !important;
    color: #7A6200 !important;
    border-color: rgba(234,179,8,0.25) !important;
}
.product-detail-page .form-section > form {
    background: #FFFBEB !important;
    border-color: rgba(234,179,8,0.1) !important;
}
.product-detail-page .quantity-input:focus {
    border-color: #EAB308 !important;
    box-shadow: 0 0 0 3px rgba(234,179,8,0.1) !important;
}
.product-detail-page .cart-button {
    background: linear-gradient(135deg, #FEF9C3, #EAB308) !important;
    box-shadow: 0 6px 20px rgba(234,179,8,0.22) !important;
}
.product-detail-page .cart-button:hover {
    box-shadow: 0 10px 28px rgba(234,179,8,0.28) !important;
}
.product-detail-page .related-product-card:hover {
    border-color: rgba(234,179,8,0.2) !important;
}
.product-detail-page .related-product-button:hover {
    background: linear-gradient(135deg, #FEF9C3, #EAB308) !important;
    box-shadow: 0 5px 14px rgba(234,179,8,0.2) !important;
}

/* Zoom overlay */
.pd-zoom-overlay {
    position: fixed !important;
    inset: 0 !important;
    background: rgba(0,0,0,0.85) !important;
    z-index: 99999 !important;
    display: none !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: zoom-out !important;
    padding: 2rem !important;
    opacity: 0 !important;
    transition: opacity 0.25s ease !important;
}
.pd-zoom-overlay.active {
    display: flex !important;
    opacity: 1 !important;
}
.pd-zoom-overlay img {
    max-width: 92% !important;
    max-height: 90vh !important;
    object-fit: contain !important;
    border-radius: 16px !important;
    animation: pdZoomIn 0.3s ease !important;
}
.pd-zoom-close {
    position: fixed !important;
    top: 1rem !important;
    right: 1.25rem !important;
    width: 40px !important;
    height: 40px !important;
    border-radius: 50% !important;
    background: rgba(255,255,255,0.15) !important;
    border: none !important;
    color: #fff !important;
    font-size: 1.1rem !important;
    cursor: pointer !important;
    z-index: 100000 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: background 0.2s !important;
}
.pd-zoom-close:hover { background: rgba(255,255,255,0.25) !important; }
@keyframes pdZoomIn {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

    /* =============================================
       RESPONSIVE — TABLET
       ============================================= */
    @media (max-width: 992px) {
        .product-detail-page .image-section {
            padding: 2rem 1.5rem !important;
            min-height: 320px !important;
        }

        .product-detail-page .product-image,
        .product-detail-page .placeholder-image {
            max-width: 280px !important;
            height: 280px !important;
        }

        .product-detail-page .related-products-section .row {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.85rem !important;
        }
    }

    /* =============================================
       RESPONSIVE — MOBILE
       ============================================= */
    @media (max-width: 768px) {
        .product-container {
            padding: 0 0.85rem !important;
        }

        .product-detail-page {
            padding: 1.25rem 0 0 !important;
        }

        .product-detail-page .image-section {
            padding: 1.75rem 1rem !important;
            min-height: 280px !important;
        }

        .product-detail-page .product-image,
        .product-detail-page .placeholder-image {
            max-width: 230px !important;
            height: 230px !important;
            padding: 1rem !important;
        }

        .product-detail-page .info-section {
            padding: 1.35rem 1.25rem 1.5rem !important;
        }

        .product-detail-page .product-title {
            font-size: 1.5rem !important;
        }

        .product-detail-page .product-price {
            font-size: 1.5rem !important;
        }

        .product-detail-page .form-section > form,
        .product-detail-page .form-section > .alert-custom {
            padding: 1rem !important;
        }

        .product-detail-page .cart-button {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.88rem !important;
        }

        .product-detail-page .description-section {
            margin-top: 1rem !important;
            padding: 1rem !important;
        }

        .product-detail-page .related-products-section {
            margin-top: 2rem !important;
        }

        .product-detail-page .related-products-section .row {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.7rem !important;
        }

        .product-detail-page .related-product-image-wrapper {
            height: 140px !important;
        }

        .product-detail-page .related-product-info {
            padding: 0.85rem !important;
        }

        .product-detail-page .related-product-name {
            font-size: 0.8rem !important;
            -webkit-line-clamp: 1 !important;
        }

        .product-detail-page .related-product-price {
            font-size: 0.92rem !important;
            margin-bottom: 0.5rem !important;
        }

        .product-detail-page .related-product-button {
            padding: 0.4rem 0.65rem !important;
            font-size: 0.72rem !important;
        }
    }

    @media (max-width: 576px) {
        .product-detail-page .image-section {
            padding: 1.5rem 0.75rem !important;
            min-height: 240px !important;
        }

        .product-detail-page .product-image,
        .product-detail-page .placeholder-image {
            max-width: 195px !important;
            height: 195px !important;
            padding: 0.75rem !important;
        }

        .product-detail-page .product-title {
            font-size: 1.3rem !important;
        }

        .product-detail-page .product-price {
            font-size: 1.3rem !important;
        }

        .product-detail-page .product-category {
            font-size: 0.6rem !important;
        }

        .product-detail-page .related-product-image-wrapper {
            height: 120px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="product-detail-page">
    <div class="product-container">
        <!-- Main Product Card -->
        <div class="product-card">
            <div class="product-content">
                <!-- Image Section -->
                <div class="image-section">
    @if($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar)))
        <img src="{{ asset('images/produk/' . $produk->gambar) }}" 
             class="product-image" alt="{{ $produk->nama }}">
    @else
        <div class="placeholder-image">
            <span class="placeholder-icon">📦</span>
        </div>
    @endif

</div>
                <!-- Info Section -->
                <div class="info-section">
                    <div class="product-category">{{ $produk->kategori }}</div>
                    <h1 class="product-title">{{ $produk->nama }}</h1>
                    
                    <div class="product-price">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>
                    
                    <!-- Stock Info -->
                    <div class="stock-info">
                        <div class="stock-label">Ketersediaan:</div>
                        @if($produk->stok > 10)
                            <span class="stock-badge stock-available">
                                ✅ Stok Tersedia ({{ $produk->stok }})
                            </span>
                        @elseif($produk->stok > 0)
                            <span class="stock-badge stock-limited">
                                ⚠️ Stok Terbatas ({{ $produk->stok }})
                            </span>
                        @else
                            <span class="stock-badge stock-out">
                                ❌ Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div class="description-section">
                        <h5 class="description-title">Deskripsi Produk</h5>
                        <p class="description-text">{{ $produk->deskripsi }}</p>
                    </div>
                    
                    <!-- Form Section -->
                    <div class="form-section">
                        @auth
                            @if($produk->stok > 0)
                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="quantity-input" 
                                        value="1" min="1" max="{{ $produk->stok }}" required>
                                    
                                    <button type="submit" class="cart-button mt-3">
                                        🛒 Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <div class="alert-custom alert-danger-custom">
                                    <strong>Maaf, produk ini sedang habis.</strong>
                                </div>
                            @endif
                        @else
                            <div class="alert-custom alert-info-custom">
                                <p class="mb-2">Silakan login untuk membeli produk ini</p>
                                <a href="{{ route('login') }}" class="cart-button">
                                    Login Sekarang
                                </a>
                            </div>
                        @endauth
                    </div>
                    
                    <a href="{{ route('produk.index') }}" class="back-button">
                        ← Kembali ke Produk
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Products Section -->
        <div class="related-products-section">
            <h3 class="section-title">Produk Terkait 🎨</h3>
            <div class="row g-4">
                @php
                    $produkTerkait = \App\Models\Produk::where('kategori', $produk->kategori)
                                                        ->where('id', '!=', $produk->id)
                                                        ->limit(4)
                                                        ->get();
                @endphp
                
                @forelse($produkTerkait as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="related-product-card h-100">
                            <div class="related-product-image-wrapper">
                                @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                                    <img src="{{ asset('images/produk/' . $item->gambar) }}" 
                                         class="related-product-image" alt="{{ $item->nama }}">
                                @else
                                    <div class="related-product-placeholder">
                                        <span class="fs-1">📦</span>
                                    </div>
                                @endif
                            </div>
                            <div class="related-product-info">
                                <h5 class="related-product-name">{{ $item->nama }}</h5>
                                <div class="related-product-price">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', $item->id) }}" 
                                   class="related-product-button">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted fs-5">Tidak ada produk terkait.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var img = document.querySelector('.product-image');
    var section = document.querySelector('.image-section');
    if (!img) return;

    var ov = document.createElement('div');
    ov.className = 'pd-zoom-overlay';
    ov.innerHTML = '<button class="pd-zoom-close">✕</button><img src="" alt="Zoom">';
    document.body.appendChild(ov);

    section.addEventListener('click', function(e) {
        if (e.target === img) {
            ov.querySelector('img').src = img.src;
            ov.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    });

    ov.addEventListener('click', function(e) {
        if (e.target === ov || e.target.classList.contains('pd-zoom-close')) {
            ov.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && ov.classList.contains('active')) {
            ov.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>
@endpush
@endsection
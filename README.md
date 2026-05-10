# 🎨 DefaCraftStore

**DefaCraftStore** adalah platform e-commerce modern yang dikhususkan untuk produk dekorasi. Aplikasi ini dirancang untuk memberikan pengalaman belanja yang mulus dengan integrasi berbagai API pihak ketiga untuk pembayaran, pengiriman, dan autentikasi.

---

## 🚀 Fitur Utama

- **🔐 Google OAuth**: Login cepat dan aman menggunakan akun Google.
- **🗺️ Map Integration**: Integrasi Leaflet JS untuk pemilihan lokasi pengiriman yang akurat di peta.
- **🚚 RajaOngkir Shipping**: Perhitungan ongkos kirim otomatis hingga tingkat kecamatan menggunakan API RajaOngkir (Komerce).
- **💳 Midtrans Payment**: Sistem pembayaran otomatis dan aman dengan Midtrans Payment Gateway.
- **🛒 Shopping Cart & Wishlist**: Manajemen belanja yang interaktif.
- **📱 Responsive Design**: Tampilan yang optimal di berbagai perangkat.

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
| :--- | :--- |
| **Framework** | Laravel 13 |
| **Frontend Tooling** | Vite |
| **Styling** | Bootstrap 5, Custom CSS |
| **Database** | MySQL |
| **Maps** | Leaflet JS |
| **API Pengiriman** | RajaOngkir (Komerce) |
| **API Pembayaran** | Midtrans |
| **Auth** | Laravel Socialite (Google) |

---

## 📥 Installation Guide

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal Anda:

### 1. Clone Repository
```bash
git clone https://github.com/alphaXV46/DefaCraftStore.git
cd DefaCraftStore
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
Salin file `.env.example` menjadi `.env` dan generate application key.
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Migration & Seeding
Pastikan database Anda sudah siap, lalu jalankan migrasi beserta data dummy (Produk & User).
```bash
php artisan migrate --seed
```

### 5. Build Assets
Compile asset frontend menggunakan Vite.
```bash
npm run build
# Atau gunakan npm run dev untuk development mode
```

### 6. Run Application
```bash
php artisan serve
```

---

## ⚙️ Configuration Notes

Anda perlu mengisi variabel berikut di file `.env` agar fitur berjalan maksimal:

- **Google Console**: Daftarkan aplikasi di [Google Cloud Console](https://console.cloud.google.com/). Pastikan `GOOGLE_REDIRECT_URI` di `.env` sama dengan callback URL di console (contoh: `http://localhost:8000/auth/google/callback`).
- **RajaOngkir**: Dapatkan API Key dari portal RajaOngkir/Komerce.
- **Midtrans**: Gunakan Server Key dan Client Key dari Dashboard Midtrans (Sandbox mode untuk testing).

---



## 👨‍💻 Contact

**Geraldy Febriansyah**  
GitHub: [@alphaXV46](https://github.com/alphaXV46)  
Website: [@alphaXV46](https://defacraftstore.biz.id) (belum hosting)

---

Copyright © 2026 DefaCraftStore. Built with  by Geraldy.

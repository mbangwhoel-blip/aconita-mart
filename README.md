# Aconita Mart - Backend & Web Admin Koperasi

Sistem Manajemen Toko Koperasi & Retail POS Backend untuk **Aconita Mart**.

---

## ??? Tech Stack
- **Framework**: Laravel 13.x
- **Admin Panel**: Filament v5.10.x
- **Reactive UI**: Livewire v4.4.x
- **Database**: MySQL 8.0 (Database: `aconita_mart`)
- **API Authentication**: Laravel Sanctum (Bearer Token)
- **Environment**: Laragon Windows

---

## ?? Kredensial Login Bawaan

### 1. Web Admin (Filament Panel)
- **URL Admin**: `http://aconita-mart.test/admin` atau `http://localhost:8000/admin`
- **Email**: `admin@aconitamart.com`
- **Password**: `admin123`

### 2. Akun Kasir (POS)
- **Email**: `kasir@aconitamart.com`
- **Password**: `kasir123`

---

## ?? Fitur Backend & Filament Resources

1. **Dashboard Overview**:
   - Widget Omset Hari Ini
   - Widget Estimasi Laba Kotor / SHU Bulan Ini
   - Widget Total Anggota Aktif
   - Widget Peringatan Stok Menipis

2. **Master Data**:
   - **Kategori Barang** (`/admin/categories`): Pengelompokan sembako, minuman, snack, dll.
   - **Produk & Stok** (`/admin/products`): SKU, Barcode, HPP/Harga Beli, Harga Jual Umum, Harga Anggota, Stok & Min Stok.
   - **Supplier** (`/admin/suppliers`): Manajemen pemasok kulakan.
   - **Anggota Koperasi** (`/admin/members`): NIK, Nomor Anggota, Saldo Simpanan Belanja, Limit Kasbon/Kredit.

3. **Operasional & Transaksi**:
   - **Pembelian / Restock** (`/admin/purchases`): Pencatatan faktur kulakan dari supplier.
   - **Penjualan / POS Orders** (`/admin/orders`): Transaksi kasir (Tunai, QRIS, Transfer, Potong Simpanan Anggota, Bon/Kredit).
   - **Alokasi SHU** (`/admin/shu-allocations`): Perhitungan sisa hasil usaha tahunan berdasarkan laba kotor.

---

## ?? REST API Endpoints (Untuk Integrasi Mobile Kasir Flutter)

Base URL: `http://localhost:8000/api` atau `http://aconita-mart.test/api`

### 1. Autentikasi
- `POST /api/login` (Body: `email`, `password`) -> Mengembalikan user info & Bearer Token.
- `GET /api/me` (Header: `Authorization: Bearer {token}`) -> Info profil user.
- `POST /api/logout` (Header: `Authorization: Bearer {token}`) -> Revoke token.

### 2. Produk & Barcode
- `GET /api/products` -> Daftar semua produk aktif (bisa filter `search` & `category_id`).
- `GET /api/products/barcode/{barcode}` -> Pencarian produk instan dengan scan barcode.

### 3. Anggota Koperasi
- `GET /api/members` -> Daftar anggota aktif.
- `GET /api/members/{id}` -> Detail anggota (termasuk sisa saldo simpanan belanja & limit kasbon).

### 4. Transaksi Kasir
- `GET /api/orders` -> Riwayat transaksi penjualan.
- `POST /api/orders` -> Simpan transaksi POS baru:
  - Otomatis potong stok produk.
  - Jika metode bayar `potong_simpanan`, otomatis debet saldo simpanan anggota dan mencatat mutasi.
  - Otomatis menghitung laba kotor transaksi untuk kalkulasi SHU.

### 5. Sinkronisasi Offline POS
- `GET /api/sync/down` -> Unduh katalog produk & anggota untuk disimpan di SQLite HP.
- `POST /api/sync/up` -> Kirim antrian transaksi offline yang terkumpul saat HP tanpa koneksi.

---

## ?? Cara Menjalankan Server

Jika menggunakan Laragon:
- Buka Laragon -> Klik **Start All** (Apache/Nginx & MySQL).
- Akses langsung di browser: `http://aconita-mart.test/admin`

Atau via command line:
```bash
cd C:\laragon\www\aconita-mart
php artisan serve
# Akses: http://localhost:8000/admin
```

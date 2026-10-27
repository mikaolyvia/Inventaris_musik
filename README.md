# 🎵 Inventaris Musik - Inventory & Sales Management System

Sistem Manajemen Inventaris & Penjualan Alat Musik berbasis Laravel.

> Proyek UTS Web Programming 2 — Integrated Laravel Project

## 📋 Project Overview

Aplikasi web untuk mengelola inventaris dan penjualan alat musik. Fitur utama meliputi:
- Manajemen master data (kategori, produk, supplier)
- Transaksi pembelian (stock-in) dengan update stok otomatis
- Transaksi penjualan (stock-out) dengan validasi stok
- Dashboard ringkasan bisnis
- Role-based access control (Admin & Staff)
- Pencarian, filter, dan pagination

## ⚙️ Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0 / MariaDB >= 10.3
- Node.js & NPM (optional, untuk asset compilation)

## 🚀 Installation

```bash
# 1. Clone repository
git clone <repository-url>
cd inventaris-musik

# 2. Install dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure database in .env
# DB_DATABASE=inventaris_musik
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Create database
# Buat database 'inventaris_musik' di MySQL

# 7. Run migrations and seeders
php artisan migrate --seed

# 8. Create storage link (for product images)
php artisan storage:link

# 9. Run the application
php artisan serve
```

Akses aplikasi di: http://localhost:8000

## 🔑 Demo Account

| Role  | Email            | Password |
|-------|------------------|----------|
| Admin | admin@admin.com  | password |
| Staff | staff@admin.com  | staff123 |

## 🏗️ Features

### Authentication & Authorization
- Login/Logout
- Role-based access (Admin & Staff)
- Server-side authorization dengan middleware

### Master Data
- **Kategori**: CRUD kategori alat musik
- **Produk**: CRUD produk dengan SKU unik, harga, stok, gambar, soft delete
- **Supplier**: CRUD data supplier/pemasok

### Transaksi
- **Pembelian (Purchase)**
  - Multi-item per transaksi
  - Stok otomatis bertambah saat status completed
  - Pembatalan transaksi dengan rollback stok
  - Nomor transaksi otomatis (PUR-YYYYMMDD-XXXX)

- **Penjualan (Sale)**
  - Multi-item per transaksi
  - Validasi stok sebelum penjualan
  - Stok otomatis berkurang
  - Proteksi overselling (lockForUpdate)
  - Pembatalan dengan pemulihan stok
  - Nomor transaksi otomatis (SAL-YYYYMMDD-XXXX)

### Dashboard
- Total produk, kategori, supplier
- Penjualan hari ini & bulan ini
- Daftar produk stok rendah
- Transaksi terbaru

### Usability
- Pencarian & filter (nama, SKU, tanggal, status)
- Pagination
- Responsive design
- Flash messages (success/error)

## 📊 Database Schema (ERD)

```
users ──────────── purchases ──────── purchase_items
  │                    │                    │
  │                    │                    │
  │                suppliers              products
  │                                        │
  │                                        │
  └──────────────── sales ──────────── sale_items
                                           │
                                        products
                                           │
                                       categories
```

### Tabel:
- **users**: id, name, email, password, role (admin/staff)
- **categories**: id, name (unique)
- **products**: id, category_id (FK), sku (unique), name, description, purchase_price, selling_price, stock, minimum_stock, image, soft_deletes
- **suppliers**: id, name, phone, email, address
- **purchases**: id, supplier_id (FK), user_id (FK), purchase_number (unique), total, status, notes, purchased_at
- **purchase_items**: id, purchase_id (FK), product_id (FK), quantity, unit_cost, subtotal
- **sales**: id, user_id (FK), sale_number (unique), customer_name, total, status, notes, sold_at
- **sale_items**: id, sale_id (FK), product_id (FK), quantity, unit_price, subtotal

## 🔒 Business Rules

1. SKU produk harus unik
2. Harga dan kuantitas harus valid (> 0)
3. Penjualan tidak boleh melebihi stok tersedia
4. Stok diperbarui hanya setelah transaksi sukses
5. Total transaksi dihitung oleh server
6. Menggunakan database transaction (atomik)
7. Produk yang sudah dipakai dalam transaksi menggunakan soft delete
8. Pembatalan transaksi memulihkan stok secara konsisten

## 🛡️ Security

- CSRF protection pada semua form
- Password hashing (bcrypt)
- Server-side validation
- Server-side authorization (middleware + role check)
- Credentials tersimpan di .env (tidak di-commit)
- Output escaping di Blade

## ⚠️ Known Limitations

- Tidak ada payment gateway
- Tidak ada multi-warehouse
- Tidak ada akuntansi penuh
- Tidak ada mobile app terpisah
- Tidak ada multi-currency

## 🧪 Test Scenarios

| Scenario | Expected |
|----------|----------|
| Guest akses dashboard | Redirect ke login |
| Password salah | Ditolak dengan pesan error |
| SKU duplikat | Ditolak saat validasi |
| Harga negatif | Ditolak saat validasi |
| Pembelian sukses | Stok bertambah sesuai kuantitas |
| Penjualan sukses | Stok berkurang sesuai kuantitas |
| Stok tidak cukup | Penjualan ditolak, data tidak berubah |
| Item gagal | Seluruh transaksi rollback |
| Staff akses admin | Forbidden (403) |
| Filter & pagination | Data sesuai filter |

## 📝 Tech Stack

- **Backend**: Laravel 12
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **ORM**: Eloquent
- **Auth**: Laravel built-in authentication

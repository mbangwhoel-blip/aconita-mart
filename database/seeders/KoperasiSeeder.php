<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KoperasiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@aconitamart.com'],
            ['name' => 'Pengurus Koperasi', 'password' => Hash::make('admin123')]
        );

        $cashier = User::firstOrCreate(
            ['email' => 'kasir@aconitamart.com'],
            ['name' => 'Kasir Aconita Mart', 'password' => Hash::make('kasir123')]
        );

        // 2. Categories
        $categories = [
            ['name' => 'Sembako & Beras', 'slug' => 'sembako-beras', 'description' => 'Beras, minyak, gula, tepung'],
            ['name' => 'Minuman & Susu', 'slug' => 'minuman-susu', 'description' => 'Air mineral, kopi, teh, susu'],
            ['name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'description' => 'Snack, biskuit, mie instan'],
            ['name' => 'Kebutuhan Rumah', 'slug' => 'kebutuhan-rumah', 'description' => 'Sabun, deterjen, sampo'],
            ['name' => 'Alat Tulis Kantor', 'slug' => 'alat-tulis-kantor', 'description' => 'Buku, pulpen, map'],
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat['slug']] = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Suppliers
        $suppliers = [
            ['name' => 'PT Mitra Distribusi Sembako', 'contact_person' => 'Bambang', 'phone' => '081234567801', 'email' => 'bambang@distribusisembako.com', 'address' => 'Kawasan Pergudangan Blok A2'],
            ['name' => 'CV Sejahtera Food & Beverage', 'contact_person' => 'Dewi', 'phone' => '081234567802', 'email' => 'dewi@sejahterafood.com', 'address' => 'Jl. Industri Raya No. 45'],
            ['name' => 'Distributor Perlengkapan Rumah', 'contact_person' => 'Hendra', 'phone' => '081234567803', 'email' => 'hendra@distributor.com', 'address' => 'Ruko Sentra Niaga No. 12'],
        ];

        $supplierMap = [];
        foreach ($suppliers as $sup) {
            $supplierMap[$sup['name']] = Supplier::firstOrCreate(['name' => $sup['name']], $sup);
        }

        // 4. Members
        $members = [
            ['member_no' => 'MBR-001', 'nik' => '3201012301850001', 'name' => 'Ahmad Fauzi', 'phone' => '081298765431', 'email' => 'fauzi@koperasi.id', 'department' => 'Divisi Keuangan', 'savings_balance' => 750000, 'credit_limit' => 1000000],
            ['member_no' => 'MBR-002', 'nik' => '3201012301850002', 'name' => 'Siti Rahmawati', 'phone' => '081298765432', 'email' => 'siti@koperasi.id', 'department' => 'Divisi Operasional', 'savings_balance' => 1200000, 'credit_limit' => 1500000],
            ['member_no' => 'MBR-003', 'nik' => '3201012301850003', 'name' => 'Budi Santoso', 'phone' => '081298765433', 'email' => 'budi@koperasi.id', 'department' => 'Divisi Umum', 'savings_balance' => 350000, 'credit_limit' => 500000],
            ['member_no' => 'MBR-004', 'nik' => '3201012301850004', 'name' => 'Nurul Hidayah', 'phone' => '081298765434', 'email' => 'nurul@koperasi.id', 'department' => 'Divisi HRD', 'savings_balance' => 900000, 'credit_limit' => 1000000],
            ['member_no' => 'MBR-005', 'nik' => '3201012301850005', 'name' => 'Rian Hidayat', 'phone' => '081298765435', 'email' => 'rian@koperasi.id', 'department' => 'Divisi IT', 'savings_balance' => 1500000, 'credit_limit' => 2000000],
        ];

        $memberMap = [];
        foreach ($members as $mem) {
            $memberMap[$mem['member_no']] = Member::firstOrCreate(['member_no' => $mem['member_no']], $mem);
        }

        // 5. Products
        $products = [
            // Sembako
            ['category' => 'sembako-beras', 'barcode' => '8991001100111', 'sku' => 'SBK-BRS-05', 'name' => 'Beras Rojolele Premium 5kg', 'unit' => 'sak', 'cost_price' => 65000, 'selling_price' => 74000, 'member_price' => 71000, 'stock' => 45, 'min_stock' => 10],
            ['category' => 'sembako-beras', 'barcode' => '8991001100112', 'sku' => 'SBK-MNY-02', 'name' => 'Minyak Goreng SunCo 2L Pouch', 'unit' => 'pouch', 'cost_price' => 32000, 'selling_price' => 37000, 'member_price' => 35500, 'stock' => 60, 'min_stock' => 15],
            ['category' => 'sembako-beras', 'barcode' => '8991001100113', 'sku' => 'SBK-GLA-01', 'name' => 'Gulaku Gula Pasir Tebu 1kg', 'unit' => 'kg', 'cost_price' => 16000, 'selling_price' => 18500, 'member_price' => 17500, 'stock' => 50, 'min_stock' => 10],
            ['category' => 'sembako-beras', 'barcode' => '8991001100114', 'sku' => 'SBK-TPG-01', 'name' => 'Tepung Terigu Segitiga Biru 1kg', 'unit' => 'kg', 'cost_price' => 11000, 'selling_price' => 13500, 'member_price' => 12500, 'stock' => 30, 'min_stock' => 8],
            
            // Minuman
            ['category' => 'minuman-susu', 'barcode' => '8991002200221', 'sku' => 'MNM-AQR-60', 'name' => 'Aqua Air Mineral Botol 600ml', 'unit' => 'botol', 'cost_price' => 2800, 'selling_price' => 4000, 'member_price' => 3500, 'stock' => 120, 'min_stock' => 24],
            ['category' => 'minuman-susu', 'barcode' => '8991002200222', 'sku' => 'MNM-KOP-01', 'name' => 'Kopi Kapal Api Spesial Mix 10x24g', 'unit' => 'pack', 'cost_price' => 13500, 'selling_price' => 16500, 'member_price' => 15500, 'stock' => 40, 'min_stock' => 10],
            ['category' => 'minuman-susu', 'barcode' => '8991002200223', 'sku' => 'MNM-SSU-01', 'name' => 'Susu Ultra Milk Cokelat 1L', 'unit' => 'kotak', 'cost_price' => 17000, 'selling_price' => 20500, 'member_price' => 19500, 'stock' => 28, 'min_stock' => 6],
            
            // Makanan Ringan
            ['category' => 'makanan-ringan', 'barcode' => '8991003300331', 'sku' => 'MKN-MIE-01', 'name' => 'Indomie Goreng Spesial 85g', 'unit' => 'pcs', 'cost_price' => 2800, 'selling_price' => 3500, 'member_price' => 3200, 'stock' => 200, 'min_stock' => 40],
            ['category' => 'makanan-ringan', 'barcode' => '8991003300332', 'sku' => 'MKN-BSK-01', 'name' => 'Roma Kelapa Biskuit 300g', 'unit' => 'pack', 'cost_price' => 10000, 'selling_price' => 12500, 'member_price' => 11500, 'stock' => 35, 'min_stock' => 8],
            ['category' => 'makanan-ringan', 'barcode' => '8991003300333', 'sku' => 'MKN-SNK-01', 'name' => 'Chitato Sapi Panggang 68g', 'unit' => 'pack', 'cost_price' => 9500, 'selling_price' => 12000, 'member_price' => 11000, 'stock' => 25, 'min_stock' => 5],

            // Kebutuhan Rumah
            ['category' => 'kebutuhan-rumah', 'barcode' => '8991004400441', 'sku' => 'RMH-SBN-01', 'name' => 'Lifebuoy Sabun Mandi Cair 450ml', 'unit' => 'pouch', 'cost_price' => 22000, 'selling_price' => 27000, 'member_price' => 25000, 'stock' => 20, 'min_stock' => 5],
            ['category' => 'kebutuhan-rumah', 'barcode' => '8991004400442', 'sku' => 'RMH-DTG-01', 'name' => 'Rinso Molto Deterjen Bubuk 770g', 'unit' => 'pack', 'cost_price' => 21000, 'selling_price' => 26000, 'member_price' => 24500, 'stock' => 22, 'min_stock' => 5],
        ];

        $productMap = [];
        foreach ($products as $p) {
            $catSlug = $p['category'];
            unset($p['category']);
            $p['category_id'] = $categoryMap[$catSlug]->id;
            $productMap[$p['sku']] = Product::firstOrCreate(['sku' => $p['sku']], $p);
        }

        // 6. Sample Purchase
        $purchase = Purchase::firstOrCreate(
            ['invoice_no' => 'INV-PO-202610-001'],
            [
                'supplier_id' => $supplierMap['PT Mitra Distribusi Sembako']->id,
                'purchase_date' => now()->subDays(2),
                'total_amount' => 4500000,
                'payment_status' => 'paid',
                'notes' => 'Pengadaan stok awal bulan Mart',
            ]
        );

        // 7. Sample Orders
        $order1 = Order::firstOrCreate(
            ['order_no' => 'TRX-20261013-0001'],
            [
                'member_id' => $memberMap['MBR-001']->id,
                'cashier_id' => $cashier->id,
                'order_date' => now()->subHours(3),
                'total_amount' => 124000,
                'discount_amount' => 3000,
                'final_amount' => 121000,
                'paid_amount' => 121000,
                'change_amount' => 0,
                'payment_method' => 'potong_simpanan',
                'payment_status' => 'paid',
                'total_profit' => 16500,
                'notes' => 'Belanja mingguan anggota, debet simpanan',
            ]
        );

        if ($order1->items()->count() === 0) {
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $productMap['SBK-BRS-05']->id,
                'quantity' => 1,
                'unit_price' => 71000,
                'cost_price' => 65000,
                'subtotal' => 71000,
                'profit' => 6000,
            ]);
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $productMap['SBK-MNY-02']->id,
                'quantity' => 1,
                'unit_price' => 35500,
                'cost_price' => 32000,
                'subtotal' => 35500,
                'profit' => 3500,
            ]);
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $productMap['MNM-AQR-60']->id,
                'quantity' => 4,
                'unit_price' => 3500,
                'cost_price' => 2800,
                'subtotal' => 14000,
                'profit' => 2800,
            ]);
        }

        $order2 = Order::firstOrCreate(
            ['order_no' => 'TRX-20261013-0002'],
            [
                'member_id' => null, // Pembeli Umum
                'cashier_id' => $cashier->id,
                'order_date' => now()->subHours(1),
                'total_amount' => 57500,
                'discount_amount' => 0,
                'final_amount' => 57500,
                'paid_amount' => 60000,
                'change_amount' => 2500,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'total_profit' => 10200,
                'notes' => 'Pelanggan umum / non-member',
            ]
        );

        if ($order2->items()->count() === 0) {
            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $productMap['SBK-MNY-02']->id,
                'quantity' => 1,
                'unit_price' => 37000,
                'cost_price' => 32000,
                'subtotal' => 37000,
                'profit' => 5000,
            ]);
            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $productMap['MKN-BSK-01']->id,
                'quantity' => 1,
                'unit_price' => 12500,
                'cost_price' => 10000,
                'subtotal' => 12500,
                'profit' => 2500,
            ]);
            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $productMap['MNM-AQR-60']->id,
                'quantity' => 2,
                'unit_price' => 4000,
                'cost_price' => 2800,
                'subtotal' => 8000,
                'profit' => 2400,
            ]);
        }
    }
}

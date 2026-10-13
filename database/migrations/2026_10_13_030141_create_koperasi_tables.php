<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // 3. Members (Anggota Koperasi)
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_no')->unique();
            $table->string('nik', 30)->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('department')->nullable();
            $table->decimal('savings_balance', 14, 2)->default(0);
            $table->decimal('credit_limit', 14, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Products (Barang / Produk Mart)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('barcode')->nullable()->index();
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit')->default('pcs');
            $table->decimal('cost_price', 14, 2)->default(0);
            $table->decimal('selling_price', 14, 2)->default(0);
            $table->decimal('member_price', 14, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Purchases (Kulakan / Restock)
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('invoice_no')->unique();
            $table->date('purchase_date');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->string('payment_status')->default('paid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('cost_price', 14, 2);
            $table->decimal('subtotal', 14, 2);
            $table->timestamps();
        });

        // 6. Orders (Transaksi Penjualan POS)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('order_date');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('final_amount', 14, 2)->default(0);
            $table->decimal('paid_amount', 14, 2)->default(0);
            $table->decimal('change_amount', 14, 2)->default(0);
            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('paid');
            $table->decimal('total_profit', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 14, 2);
            $table->decimal('cost_price', 14, 2)->default(0);
            $table->decimal('subtotal', 14, 2);
            $table->decimal('profit', 14, 2)->default(0);
            $table->timestamps();
        });

        // 7. Member Savings Transactions (Riwayat Transaksi Simpanan/Saldo Belanja)
        Schema::create('member_savings_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->enum('type', ['debit_belanja', 'setoran', 'penarikan']);
            $table->decimal('amount', 14, 2);
            $table->decimal('balance_after', 14, 2);
            $table->string('reference_no')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 8. SHU Allocation (Perhitungan Estimasi SHU Koperasi)
        Schema::create('shu_allocations', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->decimal('total_revenue', 16, 2)->default(0);
            $table->decimal('total_profit', 16, 2)->default(0);
            $table->decimal('member_share_percentage', 5, 2)->default(50.00);
            $table->decimal('member_shu_pool', 16, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shu_allocations');
        Schema::dropIfExists('member_savings_transactions');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('products');
        Schema::dropIfExists('members');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
    }
};

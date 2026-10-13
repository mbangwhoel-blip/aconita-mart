<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberSavingsTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderApiController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.product', 'member', 'cashier'])
            ->latest('order_date')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'member_id' => 'nullable|exists:members,id',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $member = $request->member_id ? Member::find($request->member_id) : null;
            $orderNo = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $totalAmount = 0;
            $totalProfit = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi (sisa: {$product->stock})");
                }

                // Determine price (member price if member and available)
                $price = ($member && $product->member_price > 0)
                    ? $product->member_price
                    : $product->selling_price;

                $subtotal = $price * $item['quantity'];
                $cost = $product->cost_price * $item['quantity'];
                $profit = $subtotal - $cost;

                $totalAmount += $subtotal;
                $totalProfit += $profit;

                // Deduct stock
                $product->decrement('stock', $item['quantity']);

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $price,
                    'cost_price' => $product->cost_price,
                    'subtotal' => $subtotal,
                    'profit' => $profit,
                ];
            }

            $discount = $request->discount_amount ?? 0;
            $finalAmount = max(0, $totalAmount - $discount);
            $paidAmount = $request->paid_amount;
            $changeAmount = max(0, $paidAmount - $finalAmount);

            // Handle potong simpanan
            if ($request->payment_method === 'potong_simpanan' && $member) {
                if ($member->savings_balance < $finalAmount) {
                    throw new \Exception('Saldo simpanan anggota tidak mencukupi.');
                }
                $member->decrement('savings_balance', $finalAmount);

                MemberSavingsTransaction::create([
                    'member_id' => $member->id,
                    'type' => 'debit_belanja',
                    'amount' => $finalAmount,
                    'balance_after' => $member->fresh()->savings_balance,
                    'reference_no' => $orderNo,
                    'notes' => "Belanja POS Aconita Mart #{$orderNo}",
                ]);
            }

            $order = Order::create([
                'order_no' => $orderNo,
                'member_id' => $member?->id,
                'cashier_id' => $request->user()?->id,
                'order_date' => now(),
                'total_amount' => $totalAmount,
                'discount_amount' => $discount,
                'final_amount' => $finalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'total_profit' => $totalProfit,
                'notes' => $request->notes,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $order->load(['items.product', 'member']),
            ], 201);
        });
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncApiController extends Controller
{
    /**
     * Download Master Data katalog untuk offline cache di Flutter POS SQLite
     */
    public function syncDown()
    {
        $categories = Category::all();
        $products = Product::where('is_active', true)->get();
        $members = Member::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'timestamp' => now()->toISOString(),
            'data' => [
                'categories' => $categories,
                'products' => $products,
                'members' => $members,
            ],
        ]);
    }

    /**
     * Upload antrian transaksi offline dari Flutter POS SQLite ke MySQL
     */
    public function syncUp(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
        ]);

        $syncedOrders = [];

        DB::beginTransaction();
        try {
            foreach ($request->orders as $orderData) {
                $existing = Order::where('order_no', $orderData['order_no'])->first();
                if ($existing) {
                    $syncedOrders[] = $existing->order_no;
                    continue;
                }

                $order = Order::create([
                    'order_no' => $orderData['order_no'],
                    'member_id' => $orderData['member_id'] ?? null,
                    'cashier_id' => $request->user()?->id,
                    'order_date' => $orderData['order_date'] ?? now(),
                    'total_amount' => $orderData['total_amount'],
                    'discount_amount' => $orderData['discount_amount'] ?? 0,
                    'final_amount' => $orderData['final_amount'],
                    'paid_amount' => $orderData['paid_amount'] ?? $orderData['final_amount'],
                    'change_amount' => $orderData['change_amount'] ?? 0,
                    'payment_method' => $orderData['payment_method'] ?? 'cash',
                    'payment_status' => 'paid',
                    'total_profit' => $orderData['total_profit'] ?? 0,
                    'notes' => $orderData['notes'] ?? 'Sinkronisasi offline POS',
                ]);

                if (isset($orderData['items']) && is_array($orderData['items'])) {
                    foreach ($orderData['items'] as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'cost_price' => $item['cost_price'] ?? 0,
                            'subtotal' => $item['subtotal'],
                            'profit' => ($item['unit_price'] - ($item['cost_price'] ?? 0)) * $item['quantity'],
                        ]);

                        // Kurangi stok jika produk ada
                        $product = Product::find($item['product_id']);
                        if ($product) {
                            $product->decrement('stock', $item['quantity']);
                        }
                    }
                }

                $syncedOrders[] = $order->order_no;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sinkronisasi berhasil',
                'synced_count' => count($syncedOrders),
                'synced_orders' => $syncedOrders,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal sinkronisasi: ' . $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'grand_total' => 'required|numeric',
            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'shipping_amount' => 'nullable|numeric',
            'shipping_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat order baru
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'grand_total' => $validated['grand_total'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'status' => 'new', // status awal
                'currency' => 'USD', // Sesuaikan dengan kebutuhan Anda
                'shipping_amount' => $validated['shipping_amount'],
                'shipping_method' => $validated['shipping_method'],
                'notes' => $validated['notes'],
            ]);

            // Menyimpan item order
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $totalAmount = $product->price * $item['quantity'];

                // Kurangi stok produk
                $product->decrement('stock', $item['quantity']);

                // Simpan item order
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_amount' => $product->price,
                    'total_amount' => $totalAmount,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Order berhasil dibuat',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan, coba lagi'], 500);
        }
    }
}

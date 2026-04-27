<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang belanja kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name'   => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:255',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang belanja kosong!');
        }

        // Hitung total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Buat order
        $order = Order::create([
            'order_number'     => Order::generateOrderNumber(),
            'user_id'          => auth()->id(),
            'status'           => 'pending',
            'subtotal'         => $subtotal,
            'shipping_cost'    => 0,
            'total'            => $subtotal,
            'recipient_name'   => $request->recipient_name,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city'    => $request->shipping_city,
            'notes'            => $request->notes,
        ]);

        // Buat order items & kurangi stok
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'subtotal'     => $item['price'] * $item['quantity'],
            ]);

            // Kurangi stok
            Product::where('id', $item['product_id'])
                   ->decrement('stock', $item['quantity']);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('orders.history')
            ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
    }

    public function history()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with('items')
                       ->latest()
                       ->paginate(10);

        return view('order-history', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
                      ->with('items.product')
                      ->findOrFail($id);

        return view('order-detail', compact('order'));
    }
}
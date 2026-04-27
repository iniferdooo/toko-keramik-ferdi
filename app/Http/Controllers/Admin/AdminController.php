<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue  = Order::where('status', 'delivered')->sum('total');

        $recentOrders  = Order::with('user')
                              ->latest()
                              ->limit(5)
                              ->get();

        $lowStock = Product::where('stock', '<=', 10)
                           ->where('stock', '>', 0)
                           ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'recentOrders',
            'lowStock'
        ));
    }

    public function products(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(15)->appends(request()->query());
        $categories = Category::all();

        return view('admin.products', compact('products', 'categories'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.product-form', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'sku'         => 'required|unique:products,sku',
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'size'        => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product-form', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'sku'         => 'required|unique:products,sku,' . $id,
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'size'        => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus!');
    }

public function orders(Request $request)
{
    $query = Order::with('user');

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $orders = $query->latest()->paginate(15)->appends(request()->query()); // ← $products → $orders
    $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

    return view('admin.orders', compact('orders', 'statuses'));
}

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui!');
    }

    public function stock()
    {
        $products = Product::with('category')
                           ->orderBy('stock', 'asc')
                           ->paginate(20);

        return view('admin.stock', compact('products'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        Product::findOrFail($id)->update(['stock' => $request->stock]);

        return back()->with('success', 'Stok berhasil diperbarui!');
    }
}
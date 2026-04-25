<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('motif', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $request->category)
            );
        }

        if ($request->size) {
            $query->where('size', $request->size);
        }

        if ($request->finish) {
            $query->where('finish', $request->finish);
        }

        match($request->sort ?? 'latest') {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $sizes      = Product::distinct()->pluck('size')->sort()->values();

        return view('products.index', compact('products', 'categories', 'sizes'));
    }

    public function show($id)
    {
        $product  = Product::with('category')->findOrFail($id);
        $related  = Product::where('category_id', $product->category_id)
                           ->where('id', '!=', $id)
                           ->limit(4)
                           ->get();

        return view('products.show', compact('product', 'related'));
    }
}
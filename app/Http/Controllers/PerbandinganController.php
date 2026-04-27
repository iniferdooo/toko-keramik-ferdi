<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PerbandinganController extends Controller
{
    public function index(Request $request)
    {
        if ($request->add) {
            $compare = session()->get('compare', []);

            if (count($compare) >= 3) {
                return back()->with('error', 'Maksimal 3 produk untuk dibandingkan!');
            }

            if (!in_array($request->add, $compare)) {
                $compare[] = $request->add;
                session()->put('compare', $compare);
            }
        }

        if ($request->remove) {
            $compare = session()->get('compare', []);
            $compare = array_filter($compare, fn($id) => $id != $request->remove);
            session()->put('compare', array_values($compare));
        }

        if ($request->reset) {
            session()->forget('compare');
        } // ← ini yang kurang!

        $compareIds  = session()->get('compare', []);
        $products    = Product::with('category')
                              ->whereIn('id', $compareIds)
                              ->get();
        $allProducts = Product::select('id', 'name')->get();

        return view('product-comparison', compact('products', 'allProducts', 'compareIds'));
    }
}
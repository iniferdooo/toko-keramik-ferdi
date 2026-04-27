<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KalkulatorController extends Controller
{
    public function index()
    {
        return view('calculator');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'room_length' => 'required|numeric|min:0.1',
            'room_width'  => 'required|numeric|min:0.1',
            'tile_size'   => 'required|string',
            'waste'       => 'required|numeric|min:0|max:30',
        ]);

        // Hitung luas ruangan dalam cm²
        $roomArea = $request->room_length * $request->room_width; // m²

        // Parse ukuran keramik
        [$tileLength, $tileWidth] = explode('x', $request->tile_size);
        $tileArea = ($tileLength * $tileWidth) / 10000; // konversi cm² ke m²

        // Hitung jumlah keramik
        $baseCount  = ceil($roomArea / $tileArea);
        $wasteCount = ceil($baseCount * ($request->waste / 100));
        $totalCount = $baseCount + $wasteCount;

        // Hitung dus (1 dus = 1 m²)
        $boxCount = ceil($roomArea * (1 + $request->waste / 100));

        return view('calculator', compact(
            'roomArea',
            'baseCount',
            'wasteCount',
            'totalCount',
            'boxCount'
        ))->with('calculated', true)
          ->with('input', $request->all());
    }
}
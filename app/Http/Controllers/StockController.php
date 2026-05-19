<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::query()
            ->orderByDesc('start_date')
            ->get();

        return view('stocks.index', compact('stocks'));
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }
}

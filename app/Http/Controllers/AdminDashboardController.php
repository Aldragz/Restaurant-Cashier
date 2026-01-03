<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total pendapatan
        $totalPenjualan = Transaction::sum('total_price');

        // Produk paling sering dibeli (MULTI PRODUK)
        $produkTerlaris = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(transaction_items.quantity) as total_terjual')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_terjual')
            ->first();

        return view('admin.dashboard', compact(
            'totalPenjualan',
            'produkTerlaris'
        ));
    }
}

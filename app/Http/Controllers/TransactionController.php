<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // form transaksi
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('kasir.transactions.create', compact('products'));
    }

    // simpan transaksi
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // validasi stok cukup
        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi']);
        }

        $total = $product->price * $request->quantity;

        Transaction::create([
            'user_id'     => auth()->id(),
            'product_id'  => $product->id,
            'quantity'    => $request->quantity,
            'total_price' => $total,
        ]);

        // kurangi stok
        $product->decrement('stock', $request->quantity);

        return redirect('/kasir/transactions')->with('success', 'Transaksi berhasil');
    }

    // riwayat transaksi kasir
    public function index()
    {
        $transactions = Transaction::with(['items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('kasir.transactions.index', compact('transactions'));
    }

    public function print($id)
    {
        $transaction = Transaction::with(['items.product', 'user'])
            ->findOrFail($id);

        // Kasir hanya boleh cetak struk miliknya
        if (
            auth()->user()->role === 'kasir' &&
            $transaction->user_id !== auth()->id()
        ) {
            abort(403);
        }

        return view('kasir.transactions.print', compact('transaction'));
    }


    public function adminIndex()
    {
        $transactions = Transaction::with(['items.product', 'user'])
            ->latest()
            ->paginate(5);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function storeCart(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:tunai,qris',
            'items' => 'required'
        ]);

        $items = json_decode($request->items, true);

        if (!$items || count($items) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $total = 0;

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'payment_method' => $request->payment_method,
                'total_price' => 0,
            ]);

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($item['qty'] > $product->stock) {
                    throw new \Exception(
                        "Stok {$product->name} tidak mencukupi"
                    );
                }

                $subtotal = $product->price * $item['qty'];
                $total += $subtotal;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['qty']);
            }

            $transaction->update(['total_price' => $total]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diproses',
                'transaction_id' => $transaction->id
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function createAdmin()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('admin.transactions.create', compact('products'));
    }

}

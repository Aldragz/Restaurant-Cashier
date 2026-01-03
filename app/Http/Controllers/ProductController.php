<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // tampilkan semua produk
    public function index(Request $request)
    {
        $search = $request->query('search');

        $products = Product::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // ⬅️ penting agar pagination membawa search

        return view('admin.products.index', compact('products', 'search'));
    }


    // form tambah produk
    public function create()
    {
        return view('admin.products.create');
    }

    // simpan produk
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100|unique:products,name',
            'category' => 'required|in:makanan,minuman',
            'price'    => 'required|integer|min:1',
            'stock'    => 'required|integer|min:2',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required'     => 'Nama produk wajib diisi',
            'name.unique'       => 'Nama produk sudah digunakan',
            'category.required' => 'Kategori wajib dipilih',
            'category.in'       => 'Kategori tidak valid',
            'price.required'    => 'Harga wajib diisi',
            'price.integer'     => 'Harga harus berupa angka',
            'price.min'         => 'Harga minimal Rp 1',
            'stock.required'    => 'Stok wajib diisi',
            'stock.integer'     => 'Stok harus berupa angka',
            'stock.min'         => 'Stok minimal 2',
            'image.image'       => 'File harus berupa gambar',
            'image.mimes'       => 'Format gambar hanya JPG atau PNG',
            'image.max'         => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            $imageName = null;

            if ($request->hasFile('image')) {
                if (!$request->image->isValid()) {
                    return back()
                        ->withInput()
                        ->with('error', 'Gagal mengunggah gambar. Silakan coba lagi.');
                }

                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move(public_path('products'), $imageName);
            }

            Product::create([
                'name'     => $request->name,
                'category' => $request->category,
                'price'    => $request->price,
                'stock'    => $request->stock,
                'image'    => $imageName,
            ]);

            return redirect('/admin/products')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan pada server. Produk gagal disimpan.');
        }
    }


    // form edit
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // update produk
public function update(Request $request, Product $product)
{
    $request->validate([
        'name'     => 'required|string|max:100|unique:products,name,' . $product->id,
        'category' => 'required|in:makanan,minuman',
        'price'    => 'required|integer|min:1',
        'stock'    => 'required|integer|min:2',
        'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'name.required'     => 'Nama produk wajib diisi',
        'name.unique'       => 'Nama produk sudah digunakan',
        'category.required' => 'Kategori wajib dipilih',
        'category.in'       => 'Kategori tidak valid',
        'price.required'    => 'Harga wajib diisi',
        'price.integer'     => 'Harga harus berupa angka',
        'price.min'         => 'Harga minimal Rp 1',
        'stock.required'    => 'Stok wajib diisi',
        'stock.integer'     => 'Stok harus berupa angka',
        'stock.min'         => 'Stok minimal 2',
        'image.image'       => 'File harus berupa gambar',
        'image.mimes'       => 'Format gambar hanya JPG atau PNG',
        'image.max'         => 'Ukuran gambar maksimal 2MB',
    ]);

    try {
        if ($request->hasFile('image')) {

            if (!$request->image->isValid()) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah gambar. Silakan coba lagi.');
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('products'), $imageName);

            $product->image = $imageName;
        }

        $product->update([
            'name'     => $request->name,
            'category' => $request->category,
            'price'    => $request->price,
            'stock'    => $request->stock,
        ]);

        return redirect('/admin/products')
            ->with('success', 'Produk berhasil diperbarui');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan pada server. Produk gagal diperbarui.');
    }
}

    // hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('success', 'Produk berhasil dihapus');
    }
}

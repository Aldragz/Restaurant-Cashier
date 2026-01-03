@extends('layouts.admin')

@section('title', 'Barang & Stok')

@section('content')

<a href="/admin/products/create" class="btn btn-primary mb-3">
    + Tambah Produk
</a>

{{-- SEARCH BAR --}}
<form method="GET" class="mb-3">
    <div class="input-group" style="max-width: 350px;">
        <span class="input-group-text bg-white">
            <i class="bi bi-search"></i>
        </span>
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari nama produk..."
               value="{{ request('search') }}">
        @if(request('search'))
            <a href="/admin/products" class="btn btn-outline-secondary">
                Reset
            </a>
        @endif
    </div>
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0 align-middle">
            <thead class="table-light">
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $p)
            <tr>
                <td>
                    @if($p->image)
                        <img src="/products/{{ $p->image }}"
                             width="50"
                             class="rounded">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $p->name }}</td>
                <td>{{ ucfirst($p->category) }}</td>
                <td class="text-center">Rp {{ number_format($p->price) }}</td>
                <td class="text-center">{{ $p->stock }}</td>
                <td class="text-center">
                    <a href="/admin/products/{{ $p->id }}/edit"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="/admin/products/{{ $p->id }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    Data produk belum tersedia
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-3 d-flex justify-content-end">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

@endsection

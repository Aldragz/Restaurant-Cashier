@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<div class="card shadow-sm col-lg-8">
    <div class="card-body">

        <h5 class="mb-4">Form Edit Produk</h5>

        {{-- ERROR SERVER --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST"
              action="/admin/products/{{ $product->id }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- NAMA & KATEGORI --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           class="form-control @error('name') is-invalid @enderror">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category"
                            class="form-select @error('category') is-invalid @enderror">
                        <option value="makanan"
                            {{ old('category', $product->category) === 'makanan' ? 'selected' : '' }}>
                            Makanan
                        </option>
                        <option value="minuman"
                            {{ old('category', $product->category) === 'minuman' ? 'selected' : '' }}>
                            Minuman
                        </option>
                    </select>

                    @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- HARGA & STOK --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="price"
                           value="{{ old('price', $product->price) }}"
                           class="form-control @error('price') is-invalid @enderror">

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stok</label>
                    <input type="number"
                           name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           class="form-control @error('stock') is-invalid @enderror">

                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- GAMBAR --}}
            <div class="mb-4">
                <label class="form-label">Gambar Produk</label><br>

                @if($product->image)
                    <img src="/products/{{ $product->image }}"
                         class="img-thumbnail mb-2"
                         width="120">
                @endif

                <input type="file"
                       name="image"
                       class="form-control @error('image') is-invalid @enderror">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti gambar
                </small>

                @error('image')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/products" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Update Produk
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

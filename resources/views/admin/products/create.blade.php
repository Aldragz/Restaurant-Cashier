@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<div class="card shadow-sm col-lg-8">
    <div class="card-body">

        <h5 class="mb-4">Form Tambah Produk</h5>

        <!-- {{-- ERROR GLOBAL --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        {{-- ERROR DARI SERVER (try-catch) --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/admin/products" enctype="multipart/form-data">
            @csrf

            {{-- NAMA & KATEGORI --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Contoh: Kopi Latte">

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
                        <option value="">-- Pilih Kategori --</option>
                        <option value="makanan" {{ old('category')=='makanan'?'selected':'' }}>
                            Makanan
                        </option>
                        <option value="minuman" {{ old('category')=='minuman'?'selected':'' }}>
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
                           value="{{ old('price') }}"
                           class="form-control @error('price') is-invalid @enderror"
                           placeholder="Contoh: 15000">

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
                           value="{{ old('stock') }}"
                           class="form-control @error('stock') is-invalid @enderror"
                           placeholder="Minimal stok 2">

                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- GAMBAR --}}
            <div class="mb-4">
                <label class="form-label">Gambar Produk</label>
                <input type="file"
                       name="image"
                       class="form-control @error('image') is-invalid @enderror">

                <small class="text-muted">
                    Format JPG / PNG, maksimal 2MB
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
                    Batal
                </a>
                <button class="btn btn-primary">
                    Simpan Produk
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

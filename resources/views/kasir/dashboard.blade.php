@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <h5>Selamat datang, {{ auth()->user()->name }}</h5>
        <p class="text-muted">
            Silakan lakukan transaksi penjualan hari ini.
        </p>

        <a href="/kasir/transactions/create" class="btn btn-success">
            + Transaksi Baru
        </a>
    </div>
</div>

@endsection

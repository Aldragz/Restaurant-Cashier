@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="row g-4">

    <!-- TOTAL TRANSAKSI -->
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Transaksi</div>
                    <div class="fs-4 fw-semibold">
                        {{ \App\Models\Transaction::count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TOTAL PENDAPATAN -->
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pendapatan</div>
                    <div class="fs-5 fw-semibold text-success">
                        Rp {{ number_format($totalPenjualan) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUK TERLARIS -->
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Produk Terlaris</div>

                    @if($produkTerlaris)
                        <div class="fw-semibold">
                            {{ $produkTerlaris->name }}
                        </div>
                        <small class="text-muted">
                            {{ $produkTerlaris->total_terjual }}x terjual
                        </small>
                    @else
                        <small class="text-muted">
                            Belum ada transaksi
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

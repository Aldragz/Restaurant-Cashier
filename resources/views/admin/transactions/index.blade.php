@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="card shadow-sm">

    <div class="card-body p-0">

        <table class="table table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 18%">Tanggal</th>
                    <th style="width: 15%">Kasir</th>
                    <th>Detail Produk</th>
                    <th class="text-center" style="width: 12%">Total Item</th>
                    <th class="text-end" style="width: 15%">Total Bayar</th>
                    <th class="text-center" style="width: 10%">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $t)
                <tr>
                    {{-- Tanggal --}}
                    <td>
                        {{ $t->created_at->format('d M Y') }}<br>
                        <small class="text-muted">
                            {{ $t->created_at->format('H:i') }}
                        </small>
                    </td>

                    {{-- Kasir --}}
                    <td>
                        {{ $t->user->name }}
                    </td>

                    {{-- Detail Produk --}}
                    <td>
                        <ul class="mb-0 ps-3">
                            @foreach($t->items as $item)
                                <li>
                                    {{ $item->product->name }}
                                    <span class="text-muted">
                                        ({{ $item->quantity }} ×
                                        Rp {{ number_format($item->price) }})
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    {{-- Total Item --}}
                    <td class="text-center">
                        {{ $t->items->sum('quantity') }}
                    </td>

                    {{-- Total Bayar --}}
                    <td class="text-end fw-semibold">
                        Rp {{ number_format($t->total_price) }}
                    </td>

                    {{-- Aksi --}}
                    <td class="text-center">
                        <a href="/transactions/{{ $t->id }}/print"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                            Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- PAGINATION --}}
    @if($transactions->hasPages())
        <div class="card-footer">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>

@endsection

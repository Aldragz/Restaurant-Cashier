@extends('layouts.admin')

@section('title', 'Manajemen Kasir')

@section('content')

<a href="/admin/employees/create" class="btn btn-primary mb-3">
    + Tambah Kasir
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-bordered mb-0 align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th style="width: 180px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($employees as $e)
                <tr>
                    <td>{{ $e->name }}</td>
                    <td>{{ $e->email }}</td>
                    <td>
                        <a href="/admin/employees/{{ $e->id }}/edit"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="/admin/employees/{{ $e->id }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Hapus pegawai?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3"
                        class="text-center text-muted py-4">
                        Belum ada data kasir
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-3 d-flex justify-content-end">
    {{ $employees->links('pagination::bootstrap-5') }}
</div>

@endsection

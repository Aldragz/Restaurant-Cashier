@extends('layouts.admin')

@section('title', 'Edit Kasir')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="/admin/employees/{{ $employee->id }}"
      class="bg-white p-4 rounded shadow-sm col-md-6">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text"
               name="name"
               value="{{ $employee->name }}"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ $employee->email }}"
               class="form-control"
               required>
    </div>

    <button class="btn btn-primary">
        Update Kasir
    </button>
</form>

@endsection

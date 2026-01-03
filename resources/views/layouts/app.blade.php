<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>POS System</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #ddd;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background: #0d6efd;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar p-3">
        <h5 class="text-primary fw-bold mb-4">🛒 POS System</h5>

        <div class="list-group list-group-flush">

            <a href="/kasir/dashboard" class="list-group-item list-group-item-action">
                Kasir
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="/admin/products" class="list-group-item list-group-item-action">
                    Barang & Stok
                </a>

                <a href="/admin/transactions" class="list-group-item list-group-item-action">
                    Riwayat Transaksi
                </a>

                <a href="/admin/dashboard" class="list-group-item list-group-item-action">
                    Laporan
                </a>
            @endif

            @if(auth()->user()->role === 'kasir')
                <a href="/kasir/transactions" class="list-group-item list-group-item-action">
                    Riwayat Transaksi
                </a>
            @endif

        </div>


        <form method="POST" action="/logout" class="mt-4">
            @csrf
            <button class="btn btn-danger w-100">Keluar</button>
        </form>
    </div>

    <!-- MAIN -->
    <div class="flex-grow-1 p-4">

        <!-- TOPBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold">@yield('title')</h4>
            <div class="text-end small">
                <div>{{ auth()->user()->name }}</div>
                <div class="text-muted">{{ now()->format('d M Y H:i') }}</div>
            </div>
        </div>

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

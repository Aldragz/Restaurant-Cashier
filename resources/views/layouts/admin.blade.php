<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin POS</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #2563eb;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar-menu {
            padding: 8px;
            flex-grow: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 4px;
            transition: background-color .2s, color .2s;
        }

        /* Hover mengikuti mouse */
        .sidebar-menu a:hover {
            background-color: #f1f5f9;
            color: #2563eb;
        }

        /* Active sesuai halaman */
        .sidebar-menu a.active {
            background-color: #eef2ff;
            color: #2563eb;
            font-weight: 500;
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .sidebar-footer button {
            background: none;
            border: none;
            color: #dc2626;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
    </style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR ADMIN -->
    <aside class="sidebar">

        <!-- HEADER -->
        <div class="sidebar-header">
            <div class="sidebar-logo">🛒</div>
            <div>
                <div class="fw-semibold">Admin</div>
                <small class="text-muted">Sistem Admin</small>
            </div>
        </div>

        <!-- MENU -->
        <div class="sidebar-menu">

            <a href="/admin/dashboard"
            class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="/admin/products"
            class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                Barang & Stok
            </a>

            <a href="/kasir/transactions/create"
            class="{{ request()->is('kasir/transactions/create') ? 'active' : '' }}">
                <i class="bi bi-cart"></i>
                Menu
            </a>

            <a href="/admin/transactions"
            class="{{ request()->is('admin/transactions*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                Riwayat Transaksi
            </a>

            <a href="/admin/employees"
            class="{{ request()->is('admin/employees*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Manajemen Pegawai
            </a>

            <!-- <a href="#"
            class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i>
                Laporan
            </a>

            <a href="#"
            class="{{ request()->is('admin/pengaturan*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                Pengaturan
            </a> -->

        </div>


        <!-- FOOTER -->
        <div class="sidebar-footer">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    <!-- CONTENT -->
    <main class="flex-grow-1 p-4">
        <h4 class="mb-4">@yield('title')</h4>
        @yield('content')
    </main>

</div>

</body>
</html>

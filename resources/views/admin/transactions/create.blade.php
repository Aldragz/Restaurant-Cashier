@extends('layouts.admin')

@section('title', 'Menu')

<style>
    /* Container list produk kasir */
    .product-list-wrapper {
        max-height: 550px; /* ± 2 baris (tergantung tinggi card) */
        overflow-y: auto;
        padding-right: 8px;
    }

    /* Scrollbar lebih halus (opsional) */
    .product-list-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .product-list-wrapper::-webkit-scrollbar-thumb {
        background-color: #466b97ff;
        border-radius: 10px;
    }

    .product-list-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .filter-btn.active {
        background-color: #0d6efd;
        color: #fff;
    }

    /* AREA LIST PRODUK DIKUNCI */
    .product-list-wrapper {
        height: 560px;       /* FIXED HEIGHT */
        overflow-y: auto;
        padding-right: 8px;
    }

    /* biar grid tetap rapi */
    .product-card {
        height: 100%;
    }


</style>


@section('content')

<form method="POST" action="/admin/transactions/store-cart" id="cart-form">
@csrf

<input type="hidden" name="payment_method" id="payment_method" value="tunai">
<input type="hidden" name="items" id="items">

{{-- FILTER --}}
<div class="mb-3 d-flex gap-2">

    <button type="button"
        class="btn btn-sm btn-outline-primary filter-btn active"
        onclick="filterCategory('makanan', this)">
        Makanan
    </button>

    <button type="button"
        class="btn btn-sm btn-outline-primary filter-btn"
        onclick="filterCategory('minuman', this)">
        Minuman
    </button>
</div>


<div class="row g-3">

    {{-- LIST PRODUK --}}
    <div class="col-lg-8">
        <div class="product-list-wrapper">
            <div class="row g-3">
                @foreach($products as $p)
                <div class="col-md-4 product-item" data-category="{{ $p->category }}">
                    <div class="card shadow-sm h-100">

                        @if($p->image)
                            <img src="/products/{{ $p->image }}"
                                class="card-img-top"
                                style="height:140px; object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                style="height:140px;">
                                <small class="text-muted">No Image</small>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">

                            <span class="badge bg-primary mb-1">
                                {{ ucfirst($p->category) }}
                            </span>

                            <h6 class="fw-semibold mb-1">{{ $p->name }}</h6>

                            <div class="text-primary fw-bold mb-2">
                                Rp {{ number_format($p->price) }}
                            </div>

                            <small class="text-muted mb-3">
                                Stok: {{ $p->stock }}
                            </small>

                            <button type="button"
                                    class="btn btn-outline-primary btn-sm mt-auto w-100"
                                    onclick="addToCart({{ $p->id }},
                                        '{{ $p->name }}',
                                        {{ $p->price }},
                                        {{ $p->stock }})">
                                <i class="bi bi-plus"></i> Tambah
                            </button>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- KERANJANG --}}
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h6 class="fw-semibold mb-3">
                    Ringkasan Pembayaran
                    <span class="badge bg-secondary" id="cart-count">0 item</span>
                </h6>

                <div id="cart-items" class="mb-3">
                    <p class="text-muted text-center small">
                        Keranjang masih kosong
                    </p>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-3">
                    <strong>Total</strong>
                    <strong id="cart-total">Rp 0</strong>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-outline-secondary btn-sm payment-btn active"
                                onclick="setPayment('tunai', this)">
                            Tunai
                        </button>
                        <button type="button"
                                class="btn btn-outline-secondary btn-sm payment-btn"
                                onclick="setPayment('qris', this)">
                            QRIS
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary w-100 mb-2" type="submit">
                    Bayar
                </button>

                <button type="button"
                        class="btn btn-outline-danger w-100 btn-sm"
                        onclick="clearCart()">
                    Hapus Keranjang
                </button>

            </div>
        </div>
    </div>

</div>
</form>

{{-- JAVASCRIPT --}}
<script>
let cart = {};

function addToCart(id, name, price, stock) {
    if (!cart[id]) {
        cart[id] = { product_id: id, qty: 1, price, stock, name };
    } else if (cart[id].qty < stock) {
        cart[id].qty++;
    }
    syncForm();
    renderCart();
}

function changeQty(id, delta) {
    cart[id].qty += delta;
    if (cart[id].qty <= 0) delete cart[id];
    syncForm();
    renderCart();
}

function clearCart() {
    cart = {};
    syncForm();
    renderCart();
}

function setPayment(method, btn) {
    document.getElementById('payment_method').value = method;
    document.querySelectorAll('.payment-btn')
        .forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function syncForm() {
    document.getElementById('items').value =
        JSON.stringify(Object.values(cart));
}

function renderCart() {
    let container = document.getElementById('cart-items');
    let total = 0;
    let count = 0;

    container.innerHTML = '';

    Object.values(cart).forEach(item => {
        total += item.price * item.qty;
        count += item.qty;

        container.innerHTML += `
            <div class="border rounded p-2 mb-2">
                <div class="fw-semibold">${item.name}</div>
                <div class="small text-muted">
                    Rp ${item.price.toLocaleString()} x ${item.qty}
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="changeQty(${item.product_id}, -1)">−</button>
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="changeQty(${item.product_id}, 1)">+</button>
                    </div>
                    <strong>Rp ${(item.price * item.qty).toLocaleString()}</strong>
                </div>
            </div>
        `;
    });

    if (count === 0) {
        container.innerHTML =
            `<p class="text-muted text-center small">Keranjang masih kosong</p>`;
    }

    document.getElementById('cart-total').innerText =
        'Rp ' + total.toLocaleString();

    document.getElementById('cart-count').innerText =
        count + ' item';
}

function filterCategory(category, btn) {
    document.querySelectorAll('.filter-btn')
        .forEach(b => {
            b.classList.remove('active', 'btn-primary');
            b.classList.add('btn-outline-primary');
        });

    btn.classList.add('active');
    btn.classList.remove('btn-outline-primary');
    btn.classList.add('btn-primary');

    document.querySelectorAll('.product-item').forEach(item => {
        item.style.display =
            item.dataset.category === category ? 'block' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const makananBtn = document.querySelector(
        '.filter-btn[onclick*="makanan"]'
    );
    filterCategory('makanan', makananBtn);
});

</script>

@endsection

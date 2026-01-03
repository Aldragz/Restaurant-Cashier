<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>

    <style>
        body {
            font-family: "Courier New", monospace;
            width: 300px;
            font-size: 12px;
            margin: 0 auto;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .small {
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
            vertical-align: top;
        }

        .item-name {
            font-weight: bold;
        }

        .footer {
            margin-top: 10px;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="center">
        <div class="bold" style="font-size:14px;">Resto APA</div>
        <div class="small">Jl. Wibawa Mukti No. 99</div>
        <div class="small">Telp: 0812-0101-5757</div>
    </div>

    <hr>

    <!-- INFO TRANSAKSI -->
    <table class="small">
        <tr>
            <td>Tanggal</td>
            <td class="right">
                {{ $transaction->created_at->format('d/m/Y H:i') }}
            </td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="right">{{ $transaction->user->name }}</td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td class="right">
                {{ strtoupper($transaction->payment_method) }}
            </td>
        </tr>
    </table>

    <hr>

    <!-- LIST ITEM -->
    <table>
        @foreach($transaction->items as $item)
            <tr>
                <td colspan="2" class="item-name">
                    {{ $item->product->name }}
                </td>
            </tr>
            <tr class="small">
                <td>
                    {{ $item->quantity }} x Rp {{ number_format($item->price) }}
                </td>
                <td class="right">
                    Rp {{ number_format($item->subtotal) }}
                </td>
            </tr>
        @endforeach
    </table>

    <hr>

    <!-- TOTAL -->
    <table>
        <tr class="bold">
            <td>TOTAL</td>
            <td class="right">
                Rp {{ number_format($transaction->total_price) }}
            </td>
        </tr>
    </table>

    <hr>

    <!-- FOOTER -->
    <div class="center footer small">
        <div>Terima Kasih 🙏</div>
        <div>Selamat Menikmati</div>
        <br>
        <div>— Powered by Aldragz —</div>
    </div>

</body>
</html>

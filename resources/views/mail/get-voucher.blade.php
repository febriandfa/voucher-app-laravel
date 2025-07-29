<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Voucher Anda Telah Diterima!</title>
    <style>
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .voucher-code {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            background: #f2f2f2;
            padding: 10px 20px;
            border-radius: 6px;
            display: inline-block;
            margin: 20px 0;
        }

        .voucher-info {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #444;
        }

        .voucher-info p {
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <h2>Selamat! Anda Menerima Voucher Baru</h2>
    <p>Terima kasih telah menggunakan layanan kami. Berikut adalah kode voucher Anda:</p>

    <div class="voucher-code">
        {{ $voucher->id }}
    </div>

    <div class="voucher-info">
        <p><strong>Deskripsi:</strong> {{ $voucher->deskripsi }}</p>
        <p><strong>Outlet:</strong> {{ $voucher->outlet->nama }}</p>
        <p><strong>Berlaku sampai:</strong> {{ \Carbon\Carbon::parse($voucher->tanggal_kadaluarsa)->format('d M Y') }}
        </p>
    </div>

    <p>Tunjukkan email ini pada petugas outlet untuk menggunakan voucher Anda.</p>
    <br>

    <p>Salam,<br>Tim Voucher App</p>
</body>

</html>

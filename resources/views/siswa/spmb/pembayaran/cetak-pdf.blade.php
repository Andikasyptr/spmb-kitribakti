<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran - {{ $pembayaran->nama }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #fff;
            color: #333;
            margin: 40px;
        }
        .container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .header h1 {
            font-size: 22px;
            color: #111827;
            margin: 0;
        }
        .logo {
            width: 50px;
            height: 50px;
        }
        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .detail p {
            font-size: 14px;
            margin: 6px 0;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #065f46;
            background: #d1fae5;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Bukti Pembayaran Pendaftaran</h1>
            <p>SPMB - SMK KITRI BAKTI</p>
        </div>
        <img src="{{ public_path('images/logokitri.png') }}" class="logo" alt="Logo Sekolah">
    </div>

    <hr>

    <div class="detail">
        <p><strong>Nama Lengkap:</strong> {{ $pembayaran->nama }}</p>
        <p><strong>NISN:</strong> {{ $pembayaran->nisn }}</p>
        <p><strong>Tanggal Upload:</strong> {{ $pembayaran->created_at->format('d M Y - H:i') }}</p>
         <p><strong>Nominal Pembayaran:</strong> Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</p>
        <p><strong>Status Pembayaran:</strong> 
            <span class="badge">{{ $pembayaran->status }}</span>
        </p>
    </div>
     {{-- Bukti File Pembayaran --}}
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">📄 Bukti Pembayaran:</h2>
            @if(Str::endsWith($pembayaran->bukti_pembayaran, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" 
                     alt="Bukti Pembayaran" 
                     class="rounded-lg border w-full max-w-md">
            @else
                <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">
                    Lihat file PDF
                </a>
            @endif
        </div>

    <div class="footer">
        <p><i>Dicetak otomatis dari sistem SPMB - SMK KITRI BAKTI pada {{ now()->format('d M Y H:i') }}</i></p>
    </div>
</div>
</body>
</html>

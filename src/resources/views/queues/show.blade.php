<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Nomor Antrian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #0f172a;
        }

        .navbar {
            background: #ffffff;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }

        .nav a {
            margin-left: 20px;
            color: #334155;
            text-decoration: none;
            font-weight: bold;
        }

        .nav a:hover {
            color: #2563eb;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .ticket-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 16px 45px rgba(0,0,0,.09);
            overflow: hidden;
        }

        .ticket-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 34px;
            text-align: center;
        }

        .ticket-header span {
            display: inline-block;
            background: rgba(255,255,255,.16);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .ticket-header h1 {
            margin: 20px 0 8px;
            font-size: 64px;
            letter-spacing: -1px;
        }

        .ticket-header p {
            margin: 0;
            opacity: .9;
        }

        .ticket-body {
            padding: 34px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 22px;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: bold;
            font-size: 13px;
        }

        .badge-waiting {
            background: #e2e8f0;
            color: #334155;
        }

        .badge-called {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-done {
            background: #dcfce7;
            color: #166534;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-top: 24px;
        }

        .info-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px;
        }

        .info-item span {
            display: block;
            color: #64748b;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-item strong {
            display: block;
            font-size: 17px;
            line-height: 1.5;
        }

        .status-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 18px;
            border-radius: 16px;
            margin-top: 22px;
        }

        .status-row div span {
            display: block;
            color: #64748b;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .status-row div strong {
            font-size: 20px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 14px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #0f172a;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .note {
            margin-top: 24px;
            padding: 18px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 16px;
            line-height: 1.6;
        }

        @media (max-width: 700px) {
            .navbar {
                flex-direction: column;
                gap: 14px;
                padding: 18px 20px;
            }

            .nav a {
                margin-left: 8px;
                margin-right: 8px;
            }

            .ticket-header h1 {
                font-size: 44px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .status-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .actions .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    @php
        $statusLabel = match ($queueTicket->status) {
            'waiting' => 'Menunggu',
            'called' => 'Dipanggil',
            'done' => 'Selesai',
            'cancelled' => 'Batal',
            default => $queueTicket->status,
        };

        $statusClass = match ($queueTicket->status) {
            'waiting' => 'badge-waiting',
            'called' => 'badge-called',
            'done' => 'badge-done',
            'cancelled' => 'badge-cancelled',
            default => 'badge-waiting',
        };
    @endphp

    <div class="navbar">
        <a href="{{ route('home') }}" class="brand">PoliQueue</a>

        <div class="nav">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('queues.create') }}">Ambil Antrian</a>
            <a href="{{ route('queues.index') }}">Monitoring</a>
            <a href="/admin">Admin</a>
        </div>
    </div>

    <div class="container">
        <div class="ticket-card">
            <div class="ticket-header">
                <span>Nomor Antrian Kamu</span>

                <h1>{{ $queueTicket->queue_code }}</h1>

                <p>{{ $queueTicket->polyclinic->name ?? '-' }} - {{ $queueTicket->doctor->name ?? '-' }}</p>
            </div>

            <div class="ticket-body">
                @if (session('success'))
                    <div class="success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="status-row">
                    <div>
                        <span>Status Antrian</span>
                        <strong>
                            <span class="badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </strong>
                    </div>

                    <div>
                        <span>Estimasi Tunggu</span>
                        <strong>{{ $queueTicket->estimated_waiting_minutes }} menit</strong>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span>Nama Pasien</span>
                        <strong>{{ $queueTicket->patient->name ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Nomor HP</span>
                        <strong>{{ $queueTicket->patient->phone ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Poliklinik</span>
                        <strong>{{ $queueTicket->polyclinic->name ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Dokter</span>
                        <strong>{{ $queueTicket->doctor->name ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Tanggal Antrian</span>
                        <strong>{{ $queueTicket->queue_date?->format('d M Y') ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Keluhan</span>
                        <strong>{{ $queueTicket->complaint ?? '-' }}</strong>
                    </div>
                </div>

                <div class="note">
                    Simpan nomor antrian ini dan pantau halaman monitoring untuk melihat status panggilan terbaru.
                </div>

                <div class="actions">
                    <a href="{{ route('queues.index') }}" class="btn btn-primary">
                        Lihat Monitoring
                    </a>

                    <a href="{{ route('queues.create') }}" class="btn btn-secondary">
                        Ambil Antrian Lagi
                    </a>

                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
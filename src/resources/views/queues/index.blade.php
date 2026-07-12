<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Antrian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="refresh" content="10">

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
            background: white;
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
            max-width: 1180px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 20px;
        }

        .header h1 {
            font-size: 36px;
            margin: 0 0 8px;
        }

        .header p {
            color: #64748b;
            margin: 0;
        }

        .btn {
            padding: 13px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .called-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .called-card {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 34px;
            border-radius: 22px;
            box-shadow: 0 18px 45px rgba(37,99,235,.25);
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .called-card span {
            font-weight: bold;
            opacity: .85;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
        }

        .called-card h2 {
            font-size: 56px;
            margin: 14px 0;
            line-height: 1;
        }

        .called-card p {
            margin: 0;
            opacity: .9;
            font-size: 18px;
            line-height: 1.5;
        }

        .empty-called {
            margin-bottom: 24px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .stat-card span {
            color: #64748b;
            font-weight: bold;
        }

        .stat-card strong {
            display: block;
            font-size: 34px;
            margin-top: 8px;
        }

        .table-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .table-title {
            padding: 22px 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-title h3 {
            margin: 0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 16px 18px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
        }

        .queue-code {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .queue-code:hover {
            text-decoration: underline;
        }

        .badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-weight: bold;
            font-size: 13px;
        }

        .waiting {
            background: #e2e8f0;
            color: #334155;
        }

        .called {
            background: #fef3c7;
            color: #92400e;
        }

        .done {
            background: #dcfce7;
            color: #166534;
        }

        .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            padding: 36px;
            text-align: center;
            color: #64748b;
        }

        @media (max-width: 900px) {
            .navbar {
                flex-direction: column;
                gap: 14px;
                padding: 18px 20px;
            }

            .nav a {
                margin-left: 8px;
                margin-right: 8px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .called-card h2 {
                font-size: 46px;
            }
        }

        @media (max-width: 600px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .called-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

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
        <div class="header">
            <div>
                <h1>Monitoring Antrian</h1>
                <p>Halaman ini otomatis refresh setiap 10 detik.</p>
            </div>

            <a href="{{ route('queues.create') }}" class="btn btn-primary">
                Ambil Antrian
            </a>
        </div>

        @if ($calledQueues->count())
            <div class="called-grid">
                @foreach ($calledQueues as $calledQueue)
                    <div class="called-card">
                        <span>Sedang Dipanggil</span>

                        <h2>{{ $calledQueue->queue_code }}</h2>

                        <p>
                            {{ $calledQueue->polyclinic->name ?? '-' }}
                            -
                            {{ $calledQueue->doctor->name ?? '-' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="called-card empty-called">
                <span>Sedang Dipanggil</span>

                <h2>-</h2>

                <p>Belum ada antrian yang dipanggil</p>
            </div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <span>Total Antrian</span>
                <strong>{{ $queueTickets->count() }}</strong>
            </div>

            <div class="stat-card">
                <span>Menunggu</span>
                <strong>{{ $queueTickets->where('status', 'waiting')->count() }}</strong>
            </div>

            <div class="stat-card">
                <span>Dipanggil</span>
                <strong>{{ $queueTickets->where('status', 'called')->count() }}</strong>
            </div>

            <div class="stat-card">
                <span>Selesai</span>
                <strong>{{ $queueTickets->where('status', 'done')->count() }}</strong>
            </div>
        </div>

        <div class="table-card">
            <div class="table-title">
                <h3>Daftar Antrian Hari Ini</h3>
            </div>

            @if ($queueTickets->count())
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No. Antrian</th>
                                <th>Pasien</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th>Estimasi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($queueTickets as $queueTicket)
                                @php
                                    $statusLabel = match ($queueTicket->status) {
                                        'waiting' => 'Menunggu',
                                        'called' => 'Dipanggil',
                                        'done' => 'Selesai',
                                        'cancelled' => 'Batal',
                                        default => $queueTicket->status,
                                    };

                                    $statusClass = match ($queueTicket->status) {
                                        'waiting' => 'waiting',
                                        'called' => 'called',
                                        'done' => 'done',
                                        'cancelled' => 'cancelled',
                                        default => 'waiting',
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <a href="{{ route('queues.show', $queueTicket) }}" class="queue-code">
                                            {{ $queueTicket->queue_code }}
                                        </a>
                                    </td>

                                    <td>{{ $queueTicket->patient->name ?? '-' }}</td>
                                    <td>{{ $queueTicket->polyclinic->name ?? '-' }}</td>
                                    <td>{{ $queueTicket->doctor->name ?? '-' }}</td>

                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td>{{ $queueTicket->estimated_waiting_minutes }} menit</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty">
                    Belum ada antrian hari ini.
                </div>
            @endif
        </div>
    </div>

</body>
</html>
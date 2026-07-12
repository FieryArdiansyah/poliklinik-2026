<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Dokter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}">← Kembali ke Beranda</a>

        <h1>Jadwal Dokter</h1>

        <table>
            <thead>
                <tr>
                    <th>Dokter</th>
                    <th>Poliklinik</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Kuota</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->doctor->name ?? '-' }}</td>
                        <td>{{ $schedule->polyclinic->name ?? '-' }}</td>
                        <td>{{ ucfirst($schedule->day) }}</td>
                        <td>{{ $schedule->start_time }}</td>
                        <td>{{ $schedule->end_time }}</td>
                        <td>{{ $schedule->quota }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada jadwal dokter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
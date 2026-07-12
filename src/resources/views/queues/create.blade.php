<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ambil Antrian</title>
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
            max-width: 1100px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .header {
            margin-bottom: 28px;
        }

        .header h1 {
            font-size: 36px;
            margin: 0 0 8px;
        }

        .header p {
            color: #64748b;
            font-size: 16px;
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,.12);
        }

        textarea {
            resize: vertical;
        }

        .btn {
            border: none;
            padding: 14px 22px;
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
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

        .submit-btn {
            width: 100%;
            margin-top: 22px;
            font-size: 16px;
        }

        .info-box h3 {
            margin-top: 0;
        }

        .step {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .step strong {
            display: block;
            margin-bottom: 6px;
        }

        .step span {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        @media (max-width: 900px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .navbar {
                flex-direction: column;
                gap: 14px;
            }

            .nav a {
                margin-left: 10px;
                margin-right: 10px;
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
            <h1>Ambil Nomor Antrian</h1>
            <p>Isi data pasien dan pilih poliklinik tujuan untuk mendapatkan nomor antrian.</p>
        </div>

        <div class="layout">
            <div class="card">
                @if ($errors->any())
                    <div class="alert">
                        <strong>Data belum lengkap:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('queues.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Pasien</label>
                            <input type="text" name="patient_name" value="{{ old('patient_name') }}" placeholder="Masukkan nama pasien" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 08123456789">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="male" @selected(old('gender') === 'male')>Laki-laki</option>
                                <option value="female" @selected(old('gender') === 'female')>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Poliklinik</label>
                            <select name="polyclinic_id" required>
                                <option value="">Pilih poliklinik</option>
                                @foreach ($polyclinics as $polyclinic)
                                    <option value="{{ $polyclinic->id }}" @selected(old('polyclinic_id') == $polyclinic->id)>
                                        {{ $polyclinic->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group full">
                            <label>Dokter</label>
                            <select name="doctor_id" required>
                                <option value="">Pilih dokter</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                                        {{ $doctor->name }} - {{ $doctor->polyclinic->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group full">
                            <label>Alamat</label>
                            <textarea name="address" rows="3" placeholder="Masukkan alamat pasien">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group full">
                            <label>Keluhan</label>
                            <textarea name="complaint" rows="4" placeholder="Contoh: Demam, batuk, pusing">{{ old('complaint') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary submit-btn">
                        Ambil Nomor Antrian
                    </button>
                </form>
            </div>

            <div class="card info-box">
                <h3>Alur Antrian</h3>

                <div class="step">
                    <strong>1. Isi Data Pasien</strong>
                    <span>Masukkan data pasien dengan benar.</span>
                </div>

                <div class="step">
                    <strong>2. Pilih Poli dan Dokter</strong>
                    <span>Pilih layanan poliklinik sesuai kebutuhan pasien.</span>
                </div>

                <div class="step">
                    <strong>3. Dapat Nomor</strong>
                    <span>Sistem akan membuat nomor antrian otomatis.</span>
                </div>

                <div class="step">
                    <strong>4. Pantau Monitoring</strong>
                    <span>Lihat status antrian melalui halaman monitoring.</span>
                </div>

                <a href="{{ route('queues.index') }}" class="btn btn-secondary" style="width: 100%;">
                    Lihat Monitoring
                </a>
            </div>
        </div>
    </div>

</body>
</html>
@extends('layouts.frontend', ['title' => 'Monitoring Antrian - PoliQueue'])

@push('head')
<meta http-equiv="refresh" content="15">
@endpush

@section('content')
<section class="page">
    <div class="container">
        <div style="display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; margin-bottom: 28px; flex-wrap: wrap;">
            <div>
                <h1 class="section-title">Monitoring Antrian</h1>
                <p class="section-desc">
                    Pantau nomor yang sedang dipanggil, jumlah pasien menunggu,
                    dan status antrian hari ini. Halaman ini refresh otomatis setiap 15 detik.
                </p>
            </div>

            <a href="{{ route('queues.create') }}" class="btn btn-primary">Ambil Antrian</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 30px;">
            @forelse ($polyclinics as $polyclinic)
                <article class="card" style="padding: 24px;">
                    <div style="display: flex; justify-content: space-between; gap: 16px;">
                        <div>
                            <h3>{{ $polyclinic->name }}</h3>
                            <p style="color: var(--text-muted); margin-top: 4px;">Kode: {{ $polyclinic->code }}</p>
                        </div>

                        <span class="badge" style="color: var(--primary-dark); background: var(--primary-soft);">
                            Aktif
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 20px;">
                        <div style="padding: 12px; border-radius: 14px; background: #f8fafc;">
                            <small>Menunggu</small>
                            <strong style="display: block; font-size: 22px;">{{ $polyclinic->waiting_count }}</strong>
                        </div>

                        <div style="padding: 12px; border-radius: 14px; background: #f8fafc;">
                            <small>Dipanggil</small>
                            <strong style="display: block; font-size: 22px;">{{ $polyclinic->called_count }}</strong>
                        </div>

                        <div style="padding: 12px; border-radius: 14px; background: #f8fafc;">
                            <small>Selesai</small>
                            <strong style="display: block; font-size: 22px;">{{ $polyclinic->done_count }}</strong>
                        </div>
                    </div>
                </article>
            @empty
                <div class="card" style="padding: 24px; grid-column: 1 / -1;">
                    Belum ada poliklinik aktif.
                </div>
            @endforelse
        </div>

        <div class="card" style="padding: 28px; margin-bottom: 30px;">
            <h2 style="font-size: 28px; margin-bottom: 18px;">Sedang Dipanggil</h2>

            @if ($calledQueues->isNotEmpty())
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px;">
                    @foreach ($calledQueues as $queue)
                        <div style="padding: 26px; border-radius: 22px; background: linear-gradient(135deg, var(--primary), #1e40af); color: white;">
                            <p style="letter-spacing: 2px; font-size: 12px; font-weight: 900;">NOMOR ANTRIAN</p>
                            <div style="font-size: 48px; line-height: 1; font-weight: 900; margin: 12px 0;">
                                {{ $queue->queue_code }}
                            </div>
                            <p style="font-weight: 800;">{{ $queue->polyclinic->name }}</p>
                            <p style="opacity: .86;">{{ $queue->patient->name }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="padding: 22px; border-radius: 18px; background: #f8fafc; color: var(--text-muted);">
                    Belum ada nomor yang sedang dipanggil.
                </div>
            @endif
        </div>

        <div class="card" style="overflow: hidden;">
            <div style="padding: 24px 24px 0;">
                <h2 style="font-size: 28px;">Daftar Antrian Hari Ini</h2>
                <p style="color: var(--text-muted);">Data diambil berdasarkan tanggal hari ini.</p>
            </div>

            <div class="table-wrap">
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
                        @forelse ($queueTickets as $queue)
                            <tr>
                                <td><strong>{{ $queue->queue_code }}</strong></td>
                                <td>{{ $queue->patient->name }}</td>
                                <td>{{ $queue->polyclinic->name }}</td>
                                <td>{{ $queue->doctor->name }}</td>
                                <td>
                                    <span class="badge {{ $queue->status_class }}">
                                        {{ $queue->status_label }}
                                    </span>
                                </td>
                                <td>{{ $queue->estimated_waiting_minutes }} menit</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Belum ada antrian hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
@media (max-width: 920px) {
    div[style*="repeat(3"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
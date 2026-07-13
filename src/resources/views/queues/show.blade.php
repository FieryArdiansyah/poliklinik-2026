@extends('layouts.frontend', ['title' => 'Tiket Antrian - PoliQueue'])

@section('content')
<section class="page">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div style="display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 28px; align-items: start;">
            <div class="card" style="padding: 34px; text-align: center;">
                <p style="font-size: 13px; letter-spacing: 3px; font-weight: 900; color: var(--primary);">
                    NOMOR ANTRIAN
                </p>

                <div style="font-size: clamp(54px, 8vw, 86px); line-height: 1; font-weight: 900; margin: 18px 0; color: var(--primary);">
                    {{ $queueTicket->queue_code }}
                </div>

                <span class="badge {{ $queueTicket->status_class }}">
                    {{ $queueTicket->status_label }}
                </span>

                <p style="color: var(--text-muted); margin-top: 18px;">
                    Estimasi waktu tunggu:
                </p>

                <strong style="font-size: 30px;">
                    {{ $queueTicket->estimated_waiting_minutes }} menit
                </strong>
            </div>

            <div class="card" style="padding: 34px;">
                <h1 style="font-size: 32px; margin-bottom: 20px;">Detail Antrian</h1>

                <div style="display: grid; gap: 14px;">
                    <div>
                        <small style="color: var(--text-muted); font-weight: 800;">Nama Pasien</small>
                        <div style="font-size: 18px; font-weight: 800;">{{ $queueTicket->patient->name }}</div>
                    </div>

                    <div>
                        <small style="color: var(--text-muted); font-weight: 800;">Poliklinik</small>
                        <div style="font-size: 18px; font-weight: 800;">{{ $queueTicket->polyclinic->name }}</div>
                    </div>

                    <div>
                        <small style="color: var(--text-muted); font-weight: 800;">Dokter</small>
                        <div style="font-size: 18px; font-weight: 800;">{{ $queueTicket->doctor->name }}</div>
                    </div>

                    <div>
                        <small style="color: var(--text-muted); font-weight: 800;">Tanggal</small>
                        <div style="font-size: 18px; font-weight: 800;">{{ $queueTicket->queue_date->format('d M Y') }}</div>
                    </div>

                    <div>
                        <small style="color: var(--text-muted); font-weight: 800;">Keluhan</small>
                        <div style="font-size: 18px; font-weight: 800;">{{ $queueTicket->complaint ?: '-' }}</div>
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 26px;">
                    <a href="{{ route('queues.index') }}" class="btn btn-primary">Lihat Monitoring</a>
                    <a href="{{ route('queues.create') }}" class="btn btn-secondary">Ambil Antrian Lagi</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@media (max-width: 920px) {
    div[style*="0.9fr 1.1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
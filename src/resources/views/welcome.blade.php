@extends('layouts.frontend')

@section('content')
<section class="page">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1.08fr 0.92fr; gap: 38px; align-items: center;">
            <div class="card" style="padding: 46px; border-radius: 28px;">
                <div style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; margin-bottom: 22px; border-radius: 999px; background: var(--primary-soft); color: var(--primary-dark); font-weight: 800;">
                    <span style="width: 9px; height: 9px; border-radius: 999px; background: var(--primary); box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.12);"></span>
                    Antrian Poliklinik Real-Time
                </div>

                <h1 class="section-title">Sistem Informasi Antrian Poliklinik</h1>

                <p class="section-desc" style="margin-bottom: 28px;">
                    Ambil nomor antrian secara online, lihat estimasi waktu tunggu,
                    dan pantau status panggilan pasien melalui halaman monitoring.
                </p>

                <div style="display: flex; flex-wrap: wrap; gap: 14px;">
                    <a href="{{ route('queues.create') }}" class="btn btn-primary">Ambil Nomor Antrian</a>
                    <a href="{{ route('queues.index') }}" class="btn btn-secondary">Lihat Monitoring</a>
                </div>
            </div>

            <div style="display: flex; justify-content: center;">
                <div style="width: 100%; max-width: 500px; padding: 40px 34px; border-radius: 28px; background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%); color: white; box-shadow: 0 28px 70px rgba(37, 99, 235, 0.35); text-align: center;">
                    <p style="font-size: 14px; letter-spacing: 3px; font-weight: 800; opacity: .85;">SEDANG DIPANGGIL</p>

                    @forelse ($currentQueues as $queue)
                        <div style="font-size: clamp(48px, 7vw, 72px); line-height: 1; font-weight: 900; margin: 16px 0;">
                            {{ $queue->queue_code }}
                        </div>
                        <p style="font-size: 18px; font-weight: 700;">
                            {{ $queue->polyclinic->name }} - {{ $queue->status_label }}
                        </p>
                    @empty
                        <div style="font-size: clamp(48px, 7vw, 72px); line-height: 1; font-weight: 900; margin: 16px 0;">
                            -
                        </div>
                        <p style="font-size: 18px; font-weight: 700;">
                            Belum ada antrian dipanggil
                        </p>
                    @endforelse

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-top: 30px;">
                        <div style="padding: 14px; border-radius: 16px; background: rgba(255,255,255,.14);">
                            <span style="display: block; font-size: 12px; opacity: .8;">Menunggu</span>
                            <strong style="font-size: 22px;">{{ $totalWaiting ?? 0 }}</strong>
                        </div>

                        <div style="padding: 14px; border-radius: 16px; background: rgba(255,255,255,.14);">
                            <span style="display: block; font-size: 12px; opacity: .8;">Selesai</span>
                            <strong style="font-size: 22px;">{{ $totalDone ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section style="margin-top: 46px;">
            <div style="margin-bottom: 24px;">
                <div style="color: var(--primary); font-weight: 900;">Cara Penggunaan</div>
                <h2 style="font-size: 34px; line-height: 1.2;">Proses antrian dibuat sederhana</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px;">
                <article class="card" style="padding: 28px;">
                    <div style="width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; border-radius: 16px; background: var(--primary-soft); color: var(--primary); font-size: 22px; font-weight: 900;">1</div>
                    <h3>Ambil Antrian</h3>
                    <p style="color: var(--text-muted); margin-top: 8px;">Pasien mengisi data dan memilih poliklinik tujuan.</p>
                </article>

                <article class="card" style="padding: 28px;">
                    <div style="width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; border-radius: 16px; background: var(--primary-soft); color: var(--primary); font-size: 22px; font-weight: 900;">2</div>
                    <h3>Dapat Nomor</h3>
                    <p style="color: var(--text-muted); margin-top: 8px;">Sistem membuat nomor antrian otomatis berdasarkan kode poli.</p>
                </article>

                <article class="card" style="padding: 28px;">
                    <div style="width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; border-radius: 16px; background: var(--primary-soft); color: var(--primary); font-size: 22px; font-weight: 900;">3</div>
                    <h3>Monitoring</h3>
                    <p style="color: var(--text-muted); margin-top: 8px;">Pasien melihat status antrian dan estimasi waktu tunggu.</p>
                </article>
            </div>
        </section>

        <section style="margin-top: 46px;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px;">
                @forelse ($polyclinics as $polyclinic)
                    <article class="card" style="padding: 22px;">
                        <h3>{{ $polyclinic->name }}</h3>
                        <p style="color: var(--text-muted); margin: 8px 0 14px;">{{ $polyclinic->description ?? 'Layanan poliklinik aktif.' }}</p>

                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <span class="badge" style="color: var(--primary-dark); background: var(--primary-soft);">Kode: {{ $polyclinic->code }}</span>
                            <span class="badge status-waiting">{{ $polyclinic->waiting_count }} Menunggu</span>
                        </div>
                    </article>
                @empty
                    <div class="card" style="padding: 24px; grid-column: 1 / -1;">
                        Belum ada data poliklinik aktif. Tambahkan melalui admin panel.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</section>

<style>
@media (max-width: 920px) {
    section.page > .container > div:first-child,
    section.page .container section div[style*="repeat(3"],
    section.page .container section div[style*="repeat(4"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
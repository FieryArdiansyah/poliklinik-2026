@extends('layouts.frontend', ['title' => 'Ambil Antrian - PoliQueue'])

@section('content')
<section class="page">
    <div class="container">
        <div style="margin-bottom: 28px;">
            <h1 class="section-title">Ambil Nomor Antrian</h1>
            <p class="section-desc">
                Isi data pasien dengan benar, pilih poliklinik dan dokter tujuan,
                lalu sistem akan membuat nomor antrian otomatis.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                Data belum valid. Silakan cek kembali form di bawah.
            </div>
        @endif

        <form method="POST" action="{{ route('queues.store') }}" class="card" style="padding: 30px;">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="patient_name">Nama Pasien</label>
                    <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" placeholder="Masukkan nama lengkap">
                    @error('patient_name') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="phone">No. HP</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890">
                    @error('phone') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select id="gender" name="gender">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="male" @selected(old('gender') === 'male')>Laki-laki</option>
                        <option value="female" @selected(old('gender') === 'female')>Perempuan</option>
                    </select>
                    @error('gender') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group full">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" placeholder="Masukkan alamat pasien">{{ old('address') }}</textarea>
                    @error('address') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="polyclinic_id">Poliklinik Tujuan</label>
                    <select id="polyclinic_id" name="polyclinic_id">
                        <option value="">Pilih poliklinik</option>
                        @foreach ($polyclinics as $polyclinic)
                            <option value="{{ $polyclinic->id }}" @selected((string) old('polyclinic_id') === (string) $polyclinic->id)>
                                {{ $polyclinic->name }} ({{ $polyclinic->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('polyclinic_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="doctor_id">Dokter</label>
                    <select id="doctor_id" name="doctor_id">
                        <option value="">Pilih dokter</option>
                        @foreach ($doctors as $doctor)
                            <option
                                value="{{ $doctor->id }}"
                                data-polyclinic="{{ $doctor->polyclinic_id }}"
                                @selected((string) old('doctor_id') === (string) $doctor->id)
                            >
                                {{ $doctor->name }} - {{ $doctor->polyclinic?->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group full">
                    <label for="complaint">Keluhan</label>
                    <textarea id="complaint" name="complaint" placeholder="Contoh: demam, pusing, sakit gigi, kontrol rutin">{{ old('complaint') }}</textarea>
                    @error('complaint') <div class="error-text">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Buat Nomor Antrian</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const polyclinicSelect = document.getElementById('polyclinic_id');
    const doctorSelect = document.getElementById('doctor_id');
    const doctorOptions = Array.from(doctorSelect.options);

    function filterDoctors() {
        const selectedPolyclinic = polyclinicSelect.value;

        doctorOptions.forEach(option => {
            if (!option.value) {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const isMatch = option.dataset.polyclinic === selectedPolyclinic;

            option.hidden = !isMatch;
            option.disabled = !isMatch;
        });

        const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];

        if (selectedOption && selectedOption.disabled) {
            doctorSelect.value = '';
        }
    }

    polyclinicSelect.addEventListener('change', filterDoctors);
    filterDoctors();
</script>
@endpush
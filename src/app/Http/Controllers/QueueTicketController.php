<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\QueueTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueTicketController extends Controller
{
    public function index()
    {
        $queueTickets = QueueTicket::with(['patient', 'doctor', 'polyclinic'])
            ->whereDate('queue_date', today())
            ->orderBy('created_at')
            ->get();

        // Ambil semua antrian yang sedang dipanggil
        // Jadi kalau ada Poli Umum, Poli Gigi, Poli Anak yang dipanggil bersamaan,
        // semuanya akan tampil di halaman monitoring.
        $calledQueues = QueueTicket::with(['patient', 'doctor', 'polyclinic'])
            ->whereDate('queue_date', today())
            ->where('status', 'called')
            ->orderBy('called_at')
            ->get();

        return view('queues.index', compact('queueTickets', 'calledQueues'));
    }

    public function create()
    {
        $polyclinics = Polyclinic::where('is_active', true)
            ->orderBy('name')
            ->get();

        $doctors = Doctor::with('polyclinic')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('queues.create', compact('polyclinics', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'gender' => ['nullable', 'in:male,female'],
            'polyclinic_id' => ['required', 'exists:polyclinics,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'complaint' => ['nullable', 'string'],
        ]);

        $queueTicket = DB::transaction(function () use ($validated) {
            $patient = Patient::create([
                'name' => $validated['patient_name'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'gender' => $validated['gender'] ?? null,
            ]);

            $polyclinic = Polyclinic::findOrFail($validated['polyclinic_id']);

            $totalQueueToday = QueueTicket::where('polyclinic_id', $polyclinic->id)
                ->whereDate('queue_date', today())
                ->count();

            $queueNumber = $totalQueueToday + 1;

            $queueCode = strtoupper($polyclinic->code) . '-' . str_pad($queueNumber, 3, '0', STR_PAD_LEFT);

            $waitingBefore = QueueTicket::where('polyclinic_id', $polyclinic->id)
                ->whereDate('queue_date', today())
                ->whereIn('status', ['waiting', 'called'])
                ->count();

            $estimatedWaitingMinutes = $waitingBefore * 5;

            return QueueTicket::create([
                'patient_id' => $patient->id,
                'polyclinic_id' => $validated['polyclinic_id'],
                'doctor_id' => $validated['doctor_id'],
                'queue_code' => $queueCode,
                'queue_date' => today(),
                'status' => 'waiting',
                'estimated_waiting_minutes' => $estimatedWaitingMinutes,
                'complaint' => $validated['complaint'] ?? null,
            ]);
        });

        return redirect()
            ->route('queues.show', $queueTicket)
            ->with('success', 'Nomor antrian berhasil dibuat.');
    }

    public function show(QueueTicket $queueTicket)
    {
        $queueTicket->load(['patient', 'doctor', 'polyclinic']);

        return view('queues.show', compact('queueTicket'));
    }
}
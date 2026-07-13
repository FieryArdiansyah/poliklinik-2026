<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\QueueTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QueueTicketController extends Controller
{
    private const ESTIMATED_MINUTES_PER_PATIENT = 5;

    public function index()
    {
        $today = today();

        $queueTickets = QueueTicket::query()
            ->with(['patient', 'doctor', 'polyclinic'])
            ->whereDate('queue_date', $today)
            ->orderBy('polyclinic_id')
            ->orderBy('created_at')
            ->get();

        $calledQueues = QueueTicket::query()
            ->with(['patient', 'doctor', 'polyclinic'])
            ->whereDate('queue_date', $today)
            ->where('status', QueueTicket::STATUS_CALLED)
            ->orderBy('called_at')
            ->get();

        $polyclinics = Polyclinic::query()
            ->where('is_active', true)
            ->withCount([
                'queueTickets as waiting_count' => fn ($query) => $query
                    ->whereDate('queue_date', $today)
                    ->where('status', QueueTicket::STATUS_WAITING),

                'queueTickets as called_count' => fn ($query) => $query
                    ->whereDate('queue_date', $today)
                    ->where('status', QueueTicket::STATUS_CALLED),

                'queueTickets as done_count' => fn ($query) => $query
                    ->whereDate('queue_date', $today)
                    ->where('status', QueueTicket::STATUS_DONE),
            ])
            ->orderBy('name')
            ->get();

        return view('queues.index', compact(
            'queueTickets',
            'calledQueues',
            'polyclinics'
        ));
    }

    public function create()
    {
        $polyclinics = Polyclinic::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $doctors = Doctor::query()
            ->with('polyclinic')
            ->where('is_active', true)
            ->whereHas('polyclinic', fn ($query) => $query->where('is_active', true))
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
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'polyclinic_id' => [
                'required',
                Rule::exists('polyclinics', 'id')->where(fn ($query) => $query->where('is_active', true)),
            ],
            'doctor_id' => [
                'required',
                Rule::exists('doctors', 'id')->where(function ($query) use ($request) {
                    return $query
                        ->where('is_active', true)
                        ->where('polyclinic_id', $request->integer('polyclinic_id'));
                }),
            ],
            'complaint' => ['nullable', 'string', 'max:1000'],
        ], [
            'patient_name.required' => 'Nama pasien wajib diisi.',
            'polyclinic_id.required' => 'Poliklinik wajib dipilih.',
            'doctor_id.required' => 'Dokter wajib dipilih.',
            'doctor_id.exists' => 'Dokter tidak sesuai dengan poliklinik yang dipilih.',
        ]);

        $queueTicket = DB::transaction(function () use ($validated) {
            $patient = Patient::create([
                'name' => $validated['patient_name'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
            ]);

            $polyclinic = Polyclinic::query()
                ->where('is_active', true)
                ->lockForUpdate()
                ->findOrFail($validated['polyclinic_id']);

            $totalQueueToday = QueueTicket::query()
                ->where('polyclinic_id', $polyclinic->id)
                ->whereDate('queue_date', today())
                ->lockForUpdate()
                ->count();

            $queueNumber = $totalQueueToday + 1;

            $queueCode = strtoupper($polyclinic->code) . '-' . str_pad((string) $queueNumber, 3, '0', STR_PAD_LEFT);

            $waitingBefore = QueueTicket::query()
                ->where('polyclinic_id', $polyclinic->id)
                ->whereDate('queue_date', today())
                ->whereIn('status', [
                    QueueTicket::STATUS_WAITING,
                    QueueTicket::STATUS_CALLED,
                ])
                ->lockForUpdate()
                ->count();

            return QueueTicket::create([
                'patient_id' => $patient->id,
                'polyclinic_id' => $polyclinic->id,
                'doctor_id' => $validated['doctor_id'],
                'queue_code' => $queueCode,
                'queue_date' => today(),
                'status' => QueueTicket::STATUS_WAITING,
                'estimated_waiting_minutes' => $waitingBefore * self::ESTIMATED_MINUTES_PER_PATIENT,
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
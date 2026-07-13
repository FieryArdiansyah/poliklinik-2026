<?php

use App\Http\Controllers\QueueTicketController;
use App\Models\Polyclinic;
use App\Models\QueueTicket;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

Route::get('/', function () {
    $today = today();

    $polyclinics = Polyclinic::query()
        ->where('is_active', true)
        ->withCount([
            'queueTickets as waiting_count' => fn ($query) => $query
                ->whereDate('queue_date', $today)
                ->where('status', 'waiting'),

            'queueTickets as called_count' => fn ($query) => $query
                ->whereDate('queue_date', $today)
                ->where('status', 'called'),

            'queueTickets as done_count' => fn ($query) => $query
                ->whereDate('queue_date', $today)
                ->where('status', 'done'),
        ])
        ->orderBy('name')
        ->get();

    $currentQueues = QueueTicket::query()
        ->with(['patient', 'polyclinic'])
        ->whereDate('queue_date', $today)
        ->where('status', 'called')
        ->latest('called_at')
        ->limit(4)
        ->get();

    $totalWaiting = QueueTicket::query()
        ->whereDate('queue_date', $today)
        ->where('status', 'waiting')
        ->count();

    $totalDone = QueueTicket::query()
        ->whereDate('queue_date', $today)
        ->where('status', 'done')
        ->count();

    return view('welcome', compact(
        'polyclinics',
        'currentQueues',
        'totalWaiting',
        'totalDone'
    ));
})->name('home');

Route::get('/antrian', [QueueTicketController::class, 'index'])->name('queues.index');
Route::get('/antrian/ambil', [QueueTicketController::class, 'create'])->name('queues.create');
Route::post('/antrian', [QueueTicketController::class, 'store'])->name('queues.store');
Route::get('/antrian/{queueTicket}', [QueueTicketController::class, 'show'])->name('queues.show');

Route::get('/ambil-antrian', fn () => redirect()->route('queues.create'))->name('ambil-antrian');
Route::get('/monitoring', fn () => redirect()->route('queues.index'))->name('monitoring');
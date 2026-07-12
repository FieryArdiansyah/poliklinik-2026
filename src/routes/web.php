<?php

use App\Http\Controllers\QueueTicketController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/antrian', [QueueTicketController::class, 'index'])->name('queues.index');
Route::get('/antrian/ambil', [QueueTicketController::class, 'create'])->name('queues.create');
Route::post('/antrian', [QueueTicketController::class, 'store'])->name('queues.store');
Route::get('/antrian/{queueTicket}', [QueueTicketController::class, 'show'])->name('queues.show');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\AuthController;

// Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/settings', [AuthController::class, 'showSettings'])->name('settings');
    Route::post('/settings', [AuthController::class, 'updateSettings'])->name('settings.update');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/register-event/{event_id}', [ParticipantController::class, 'showSelfRegister'])->name('participants.self-register.form');
    Route::post('/register-event/{event_id}', [ParticipantController::class, 'selfRegister'])->name('participants.self-register');
    
    Route::get('/events/export/pdf', [EventController::class, 'exportPdf'])->name('events.export.pdf');
    Route::resource('events', EventController::class);
    Route::resource('venues', VenueController::class);
    
    Route::resource('participants', ParticipantController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('rankings', RankingController::class);
    Route::resource('speakers', SpeakerController::class);
    
    Route::get('/github/{username}', [SpeakerController::class, 'fetchGithub']);
    Route::get('/devto/{username}', [SpeakerController::class, 'fetchDevto']);
    
    Route::resource('reviews', ReviewController::class);
    Route::patch('/reviews/{id}/toggle', [ReviewController::class, 'toggleStatus'])->name('reviews.toggle');
});

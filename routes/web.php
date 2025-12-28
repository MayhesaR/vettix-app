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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/events', [DashboardController::class, 'index'])->name('events.index');
Route::get('/venues', [DashboardController::class, 'index'])->name('venues.index');
Route::get('/rankings', [DashboardController::class, 'index'])->name('rankings.index');
Route::get('/certificates', [DashboardController::class, 'index'])->name('certificates.index');
Route::get('/speakers', [DashboardController::class, 'index'])->name('speakers.index');
Route::get('/reviews', [DashboardController::class, 'index'])->name('reviews.index');


Route::resource('events', EventController::class);
Route::resource('venues', VenueController::class);
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::post('/venues', [VenueController::class, 'store'])->name('venues.store');
Route::delete('/venues/{id}', [VenueController::class, 'destroy'])->name('venues.destroy');
Route::resource('participants', ParticipantController::class);
Route::resource('certificates', CertificateController::class);
Route::resource('rankings', RankingController::class);
Route::resource('speakers', SpeakerController::class);
Route::get('/github/{username}', [SpeakerController::class, 'fetchGithub']);
Route::get('/devto/{username}', [SpeakerController::class, 'fetchDevto']);
Route::resource('reviews', ReviewController::class);
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::patch('/reviews/{id}/toggle', [ReviewController::class, 'toggleStatus'])->name('reviews.toggle');
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');



<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParkhausController;
use App\Http\Controllers\EinAusfahrtController;
use App\Http\Controllers\KassenautomatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Login Route
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin/login', function () {
    $credentials = request()->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials, request('remember'))) {
        request()->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    return back()->withErrors([
        'email' => 'Die angegebenen Anmeldedaten stimmen nicht überein.',
    ]);
})->name('admin.login.post');

// Admin Logout Route
Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
})->name('admin.logout');

// Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Parkhaus-Verwaltung
    Route::get('/parkhaus', [AdminController::class, 'parkhausIndex'])->name('parkhaus.index');
    Route::get('/parkhaus/{parkhaus}', [AdminController::class, 'parkhausShow'])->name('parkhaus.show');

    // Admin-Verwaltung
    Route::get('/admins', [AdminController::class, 'adminIndex'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'adminCreate'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'adminStore'])->name('admins.store');
});

// Bestehende Parkhaus-Routen
Route::get('/parkhaus', [ParkhausController::class, 'index'])->name('parkhaus.index');
Route::post('/parkhaus', [ParkhausController::class, 'store'])->name('parkhaus.store');

// Ein-/Ausfahrt-Routen
Route::post('/ein-ausfahrt/einfahrt', [EinAusfahrtController::class, 'einfahrt'])->name('ein-ausfahrt.einfahrt');
Route::post('/ein-ausfahrt/ausfahrt', [EinAusfahrtController::class, 'ausfahrt'])->name('ein-ausfahrt.ausfahrt');

// Kassenautomat-Routen
Route::post('/kassenautomat/zeige-betrag', [KassenautomatController::class, 'zeigeBetrag'])->name('kassenautomat.zeige-betrag');
Route::post('/kassenautomat/barzahlung', [KassenautomatController::class, 'barzahlung'])->name('kassenautomat.barzahlung');
Route::post('/kassenautomat/kreditkartenzahlung', [KassenautomatController::class, 'kreditkartenzahlung'])->name('kassenautomat.kreditkartenzahlung');

require __DIR__.'/auth.php';

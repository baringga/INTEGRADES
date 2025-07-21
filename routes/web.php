<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PartisipanCampaignController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\PengaduanController;

// Rute Publik (Bisa diakses tanpa login)
Route::get('/', function () { return view('landingpage'); });
Route::get('/login', function () { return view('account.login'); })->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('password-reset', function () { return view('account.password-reset'); })->name('password.request');
Route::post('password-reset', [ForgotPasswordController::class, 'checkEmail'])->name('password.reset.check');
Route::get('change-password', [ForgotPasswordController::class, 'showChangePasswordForm'])->name('password.reset.form');
Route::post('change-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
Route::get('/register', function (\Illuminate\Http\Request $request) {
    $role = $request->query('role');
    if (!in_array($role, ['volunteer_desa', 'masyarakat_desa'])) {
        return view('account.reg-role');
    }
    return view('account.register', compact('role'));
})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('account.register');
Route::get('/reg-success', function () { return view('account.reg-success'); })->name('reg-success');

// Rute yang Memerlukan Login (Autentikasi)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Pengaduan
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

    // Rute Campaign
    Route::get('/campaign/tambah', [CampaignController::class, 'create'])->name('campaign.tambah');
    Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign.store');
    Route::get('/campaign/{id}', [CampaignController::class, 'show'])->name('detailcam');
    Route::get('/campaign/{id}/edit', [CampaignController::class, 'edit'])->name('editcampaign');
    Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign.update');

    // Partisipan & Manajemen Campaign
    Route::get('/campaign/{id}/daftar', [PartisipanCampaignController::class, 'create'])->name('partisipan.create');
    Route::post('/campaign/{id}/daftar', [PartisipanCampaignController::class, 'store'])->name('partisipan.store');
    Route::get('/campaign/{id}/manage', [CampaignController::class, 'manage'])->name('campaign.manage');
    Route::post('/partisipan/{partisipanId}/update-status', [CampaignController::class, 'updateStatus'])->name('partisipan.updateStatus');

    // Profil
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');

    // RUTE UNTUK HALAMAN "LIHAT SEMUA"
    Route::get('/profil/laporan-saya', [ProfilController::class, 'laporanSaya'])->name('profil.laporan');
    Route::get('/campaigns/diikuti', [DashboardController::class, 'campaignFollowed'])->name('campaign.followed');
    Route::get('/campaigns/dibuat', [DashboardController::class, 'campaignCreated'])->name('campaign.created');
    Route::get('/campaigns/rekomendasi', [DashboardController::class, 'allRekomendasi'])->name('campaign.recommendations');

    // Fitur Lainnya
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::post('/campaign/{id}/bookmark', [CampaignController::class, 'bookmark'])->name('campaign.bookmark');
    Route::delete('/campaign/{id}/bookmark', [CampaignController::class, 'unbookmark'])->name('campaign.unbookmark');

    // Komentar
    Route::post('/campaign/{id}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
    Route::post('/komentar/{id}/like', [KomentarController::class, 'like'])->name('komentar.like');
    Route::patch('/komentar/{id}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::delete('/komentar/{id}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
});

// Handle 404
Route::fallback(function () {
    return view('halamanerror');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilCommunityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PartisipanCampaignController;
use App\Models\Campaign;
use App\Http\Controllers\KomentarLikeController;
use App\Http\Controllers\KomentarController;

Route::get('/', function () {
    return view('landingpage');
});

// Route yang bebas diakses
Route::get('/register', function (\Illuminate\Http\Request $request) {
    $role = $request->query('role');
    if (!in_array($role, ['komunitas', 'volunteer'])) {
        return view('account.reg-role');
    }
    return view('account.register', compact('role'));
})->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('account.register');

Route::get('/reg-success', function () {
    return view('account.reg-success');
})->name('reg-success');

Route::get('/login', function () {
    return view('account/login');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password-reset', function () {
    return view('account/password-reset');
})->name('password.request');

Route::post('password-reset', [ForgotPasswordController::class, 'checkEmail'])->name('password.reset.check');
Route::get('change-password', [ForgotPasswordController::class, 'showChangePasswordForm'])->name('password.reset.form');
Route::post('change-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'updatePassword'])->name('password.update');

// Route yang hanya bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');

    Route::get('/campaign/tambah', function () {
        return view('TambahCampaign');
    })->name('campaign.tambah');
    Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign.store');

    Route::get('/editcampaign/{id}', [CampaignController::class, 'edit'])->name('editcampaign');
    Route::get('/hapuscampaign', function () {
        return view('hapuscampaign');
    });

    Route::get('/profil/campaign-followed', [DashboardController::class, 'campaignFollowed'])->name('campaign.followed');
    Route::get('/profil/campaign-created', [DashboardController::class, 'campaignCreated'])->name('campaign.created');
    Route::get('/campaign-recommendations', [DashboardController::class, 'allRekomendasi'])->name('allrekomendasi');

    Route::get('/profilcommunity', [ProfilCommunityController::class, 'show'])->name('profilcommunity');
    Route::get('/campaigncontoh/{id}', [CampaignController::class, 'show']);

    Route::get('/campaign/{id}', [CampaignController::class, 'show'])->name('detailcam');
    Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign.update');
    Route::get('/campaign/{id}/nullify', [CampaignController::class, 'nullify'])->name('campaign.nullify');
    Route::get('/campaigncom/{id}', [CampaignController::class, 'showCom'])->name('campaigncom.detail');

    Route::post('/campaign/{id}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
    Route::post('/komentar/{id}/like', [KomentarController::class, 'like'])->name('komentar.like');
    Route::patch('/komentar/{id}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::delete('/komentar/{id}', [\App\Http\Controllers\KomentarController::class, 'destroy'])->name('komentar.destroy');

    Route::get('/campaign/{id}/daftar', [PartisipanCampaignController::class, 'create'])->name('partisipan.create');
    Route::post('/campaign/{id}/daftar', [PartisipanCampaignController::class, 'store'])->name('partisipan.store');
    Route::post('/campaign/{id}/bookmark', [CampaignController::class, 'bookmark'])->name('campaign.bookmark');
    Route::delete('/campaign/{id}/bookmark', [CampaignController::class, 'unbookmark'])->name('campaign.unbookmark');
    Route::delete('campaign/gambar/hapus/{id}', [CampaignController::class, 'hapusGambar']);
    Route::post('/profil/update', [\App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
});

// Handle 404 dan 403 error
Route::fallback(function () {
    return view('halamanerror');
});


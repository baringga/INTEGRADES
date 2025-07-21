<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\PartisipanCampaign;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menyiapkan dan menampilkan data untuk halaman dashboard utama.
     */
    public function index()
    {
        $user = Auth::user();

        $semuaPengaduan = Pengaduan::with('akun')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'semua_pengaduan');

        if ($user->jenis_akun_id == 2) {
            return view('dashboard', [
                'user' => $user,
                'semuaPengaduan' => $semuaPengaduan
            ]);
        }

        $laporanAnda = Pengaduan::where('akun_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $campaignDiikuti = Campaign::whereHas('partisipanCampaigns', function ($query) use ($user) {
            $query->where('akun_id', $user->id)->where('status', 'approved');
        })
        ->with('coverImage')
        ->orderBy('waktu', 'desc')
        ->take(3)
        ->get();

        $campaignDibuat = Campaign::where('akun_id', $user->id)
            ->with('coverImage')
            ->orderBy('waktu', 'desc')
            ->take(3)
            ->get();

        $rekomendasiCampaign = Campaign::with('coverImage')
            ->where('akun_id', '!=', $user->id)
            ->where('waktu', '>', now())
            ->whereDoesntHave('partisipanCampaigns', function ($query) use ($user) {
                $query->where('akun_id', $user->id);
            })
            ->orderBy('waktu', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'semuaPengaduan' => $semuaPengaduan,
            'laporanAnda' => $laporanAnda,
            'campaignDiikuti' => $campaignDiikuti,
            'campaignDibuat' => $campaignDibuat,
            'rekomendasiCampaign' => $rekomendasiCampaign
        ]);
    }

    /**
     * Menampilkan semua campaign yang diikuti oleh pengguna.
     */
    public function campaignFollowed()
    {
        $user = Auth::user();
        $campaigns = Campaign::whereHas('partisipanCampaigns', function ($query) use ($user) {
            $query->where('akun_id', $user->id)->where('status', 'approved');
        })->with('coverImage')->orderBy('waktu', 'desc')->paginate(9);

        return view('all-campaigns', [ // Menggunakan view generik
            'title' => 'Campaign yang Anda Ikuti',
            'campaigns' => $campaigns,
            'emptyMessage' => 'Anda belum mengikuti campaign apapun.'
        ]);
    }

    /**
     * Menampilkan semua campaign yang dibuat oleh pengguna.
     */
    public function campaignCreated()
    {
        $user = Auth::user();
        $campaigns = Campaign::where('akun_id', $user->id)
            ->with('coverImage')->orderBy('waktu', 'desc')->paginate(9);

        return view('all-campaigns', [ // Menggunakan view generik
            'title' => 'Campaign yang Anda Buat',
            'campaigns' => $campaigns,
            'emptyMessage' => 'Anda belum membuat campaign.'
        ]);
    }

    /**
     * Menampilkan semua rekomendasi campaign.
     */
    public function allRekomendasi()
    {
        $user = Auth::user();
        $campaigns = Campaign::with('coverImage')
            ->where('akun_id', '!=', $user->id)
            ->where('waktu', '>', now())
            ->whereDoesntHave('partisipanCampaigns', function ($query) use ($user) {
                $query->where('akun_id', $user->id);
            })
            ->orderBy('waktu', 'desc')->paginate(9);

        return view('all-campaigns', [ // Menggunakan view generik
            'title' => 'Rekomendasi Campaign',
            'campaigns' => $campaigns,
            'emptyMessage' => 'Saat ini tidak ada rekomendasi campaign.'
        ]);
    }
}

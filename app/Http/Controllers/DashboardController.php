<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\PartisipanCampaign;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    /**
     * Menyiapkan dan menampilkan data untuk halaman dashboard utama.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $q = $request->query('q');
        $filterMenu = $request->query('filter_menu');

        // Default: paginator kosong
        $semuaPengaduan = new LengthAwarePaginator([], 0, 5);
        $laporanAnda = new LengthAwarePaginator([], 0, 5);
        $campaignDiikuti = new LengthAwarePaginator([], 0, 6);
        $campaignDibuat = new LengthAwarePaginator([], 0, 6);
        $rekomendasiCampaign = new LengthAwarePaginator([], 0, 6);

        if (!$filterMenu || $filterMenu == 'laporan_warga') {
            $semuaPengaduan = Pengaduan::with('akun')
                ->when($q, function($query) use ($q) {
                    $query->where('judul', 'like', "%$q%")
                          ->orWhere('isi_pengaduan', 'like', "%$q%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'semua_pengaduan');
        }

        if (!$filterMenu || $filterMenu == 'laporan_anda') {
            $laporanAnda = Pengaduan::where('akun_id', $user->id)
                ->when($q, function($query) use ($q) {
                    $query->where('judul', 'like', "%$q%")
                          ->orWhere('isi_pengaduan', 'like', "%$q%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'laporan_anda'); // gunakan paginate
        }

        if (!$filterMenu || $filterMenu == 'campaign_diikuti') {
            $campaignDiikuti = Campaign::whereHas('partisipanCampaigns', function ($query) use ($user) {
                    $query->where('akun_id', $user->id)->where('status', 'approved');
                })
                ->with('coverImage')
                ->orderBy('waktu', 'desc')
                ->paginate(6, ['*'], 'campaign_diikuti');
        }

        if (!$filterMenu || $filterMenu == 'campaign_dibuat') {
            $campaignDibuat = Campaign::where('akun_id', $user->id)
                ->when($q, function($query) use ($q) {
                    $query->where('nama', 'like', "%$q%")
                          ->orWhere('deskripsi', 'like', "%$q%");
                })
                ->with('coverImage')
                ->orderBy('waktu', 'desc')
                ->paginate(6, ['*'], 'campaign_dibuat'); // gunakan paginate
        }

        if (!$filterMenu || $filterMenu == 'rekomendasi') {
            $rekomendasiCampaign = Campaign::with('coverImage')
                ->where('akun_id', '!=', $user->id)
                ->where('waktu', '>', now())
                ->whereDoesntHave('partisipanCampaigns', function ($query) use ($user) {
                    $query->where('akun_id', $user->id);
                })
                ->when($q, function($query) use ($q) {
                    $query->where('nama', 'like', "%$q%")
                          ->orWhere('deskripsi', 'like', "%$q%");
                })
                ->orderBy('waktu', 'desc')
                ->paginate(6, ['*'], 'rekomendasi_campaign');
        }

        return view('dashboard', [
            'user' => $user,
            'semuaPengaduan' => $semuaPengaduan,
            'laporanAnda' => $laporanAnda,
            'campaignDiikuti' => $campaignDiikuti,
            'campaignDibuat' => $campaignDibuat,
            'rekomendasiCampaign' => $rekomendasiCampaign,
            'filterMenu' => $filterMenu,
            'q' => $q,
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

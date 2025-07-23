<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class ProfilVolunteerController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // Campaign yang dibuat user
        $campaigns = \App\Models\Campaign::where('akun_id', $user->id)->orderBy('waktu', 'desc')->get();

        // Campaign yang diikuti user (hanya yang sudah di-approve)
        $campaignsDiikuti = \App\Models\Campaign::whereHas('partisipanCampaigns', function ($q) use ($user) {
            $q->where('akun_id', $user->id)->where('status', 'approved');
        })->orderBy('waktu', 'desc')->get();

        // Pengaduan yang dibuat user
        $pengaduanSaya = \App\Models\Pengaduan::where('akun_id', $user->id)->orderBy('created_at', 'desc')->get();

        // Komentar yang dibuat user
        $komentarList = \App\Models\Komentar::where('komentar.akun_id', $user->id)
            ->join('campaign', 'komentar.campaign_id', '=', 'campaign.id')
            ->select('komentar.*', 'campaign.nama as nama_campaign')
            ->orderBy('komentar.waktu', 'desc')
            ->get();

        return view('profilvolunteer', compact(
            'user',
            'campaigns',
            'campaignsDiikuti',
            'pengaduanSaya',
            'komentarList'
        ));
    }
}

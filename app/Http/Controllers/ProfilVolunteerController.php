<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class ProfilVolunteerController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Ambil komentar user beserta nama campaign
        $komentarList = \DB::table('komentar')
            ->join('campaign', 'komentar.campaign_id', '=', 'campaign.id')
            ->where('komentar.akun_id', $user->id)
            ->whereNotNull('campaign.nama') // hanya campaign valid
            ->select(
                'komentar.komentar as isi_komentar',
                'komentar.waktu',
                'campaign.nama as nama_campaign',
                'campaign.id as campaign_id'
            )
            ->orderByDesc('komentar.waktu')
            ->get();

        // Campaign yang diikuti user
        $campaigns = \App\Models\Campaign::with('coverImage')
            ->whereIn('id', function($query) use ($user) {
                $query->select('campaign_id')
                    ->from('partisipan_campaign')
                    ->where('akun_id', $user->id);
            })
            ->whereNotNull('nama') // hanya campaign valid
            ->get();

        // Campaign yang ditandai user
        $campaignsDitandai = \App\Models\Campaign::with('coverImage')
            ->whereIn('id', function($query) use ($user) {
                $query->select('campaign_id')
                    ->from('campaign_ditandai')
                    ->where('akun_id', $user->id);
            })
            ->whereNotNull('nama') // hanya campaign valid
            ->get();

        // Komentar yang disukai user
        $komentarDisukai = \DB::table('komentar_disukai')
            ->join('komentar', 'komentar_disukai.komentar_id', '=', 'komentar.id')
            ->join('campaign', 'komentar.campaign_id', '=', 'campaign.id')
            ->where('komentar_disukai.akun_id', $user->id)
            ->whereNotNull('campaign.nama') // hanya campaign valid
            ->select(
                'komentar.komentar as isi_komentar',
                'komentar.waktu',
                'campaign.nama as nama_campaign',
                'campaign.id as campaign_id' // tambahkan baris ini!
            )
            ->orderByDesc('komentar.waktu')
            ->get();

        return view('profilvolunteer', compact('komentarList', 'campaigns', 'campaignsDitandai', 'komentarDisukai', 'user'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use Illuminate\Http\Request;

class ProfilCommunityController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        // Ambil atau buat data akun_komunitas jika belum ada
        $akunKomunitas = \App\Models\AkunKomunitas::firstOrCreate(
            ['akun_id' => $user->id],
            ['portofolio' => '']
        );
        $campaigns = collect();
        if ($user) {
            $campaignsAll = Campaign::with('coverImage')
                ->where('akun_id', $user->id)
                ->whereNotNull('nama') // hanya campaign yang valid
                ->get();

            $now = now();
            $campaignsBerlangsung = $campaignsAll->filter(function($c) use ($now) {
                $waktuDiperbarui = \Carbon\Carbon::parse($c->waktu_diperbarui);
                $waktu = \Carbon\Carbon::parse($c->waktu);
                return $now->gte($waktuDiperbarui->copy()->addSeconds(60)) && $now->lt($waktu);
            });
            $campaignsSelesai = $campaignsAll->filter(function($c) use ($now) {
                $waktu = \Carbon\Carbon::parse($c->waktu);
                return $now->gte($waktu);
            });
        }

        return view('profilcommunity', [
            'user' => $user,
            'akunKomunitas' => $akunKomunitas,
            'campaignsAll' => $campaignsAll ?? collect(),
            'campaignsBerlangsung' => $campaignsBerlangsung ?? collect(),
            'campaignsSelesai' => $campaignsSelesai ?? collect(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        // ...validasi dan update user...

        // Update portofolio komunitas
        $akunKomunitas = \App\Models\AkunKomunitas::firstOrNew(['akun_id' => $user->id]);
        $akunKomunitas->portofolio = $request->portofolio;
        $akunKomunitas->save();

        // ...redirect atau response...
    }
}

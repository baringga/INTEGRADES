<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartisipanCampaign;
use Illuminate\Support\Facades\Auth;

class PartisipanCampaignController extends Controller
{
    public function create($id)
    {
        return view('form-pendaftaran', ['campaign_id' => $id]);
    }

    public function store(Request $request, $campaign_id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'nomorTelepon' => 'required|digits_between:9,15|numeric',
            'motivasi' => 'nullable|string|max:200',
        ]);

        $campaign = \App\Models\Campaign::findOrFail($campaign_id);

        // Cek apakah user sudah terdaftar (terlepas dari status)
        $isRegistered = PartisipanCampaign::where('akun_id', Auth::id())
                                          ->where('campaign_id', $campaign_id)
                                          ->exists();
        if ($isRegistered) {
            return redirect()->route('partisipan.create', $campaign_id)->with('error', 'Anda sudah terdaftar di campaign ini.');
        }

        $jumlahPartisipanDisetujui = PartisipanCampaign::where('campaign_id', $campaign_id)->where('status', 'approved')->count();

        if ($campaign->kuota_partisipan && $jumlahPartisipanDisetujui >= $campaign->kuota_partisipan) {
            return redirect()->route('partisipan.create', $campaign_id)->with('penuh', true);
        }

        PartisipanCampaign::create([
            'akun_id' => Auth::id(),
            'campaign_id' => $campaign_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'nomorTelepon' => $request->nomorTelepon,
            'motivasi' => $request->motivasi,
            'status' => 'approved', // pastikan ini 'approved'
        ]);

        return redirect()->route('dashboard')->with('success', 'Berhasil mendaftar campaign!');
    }

    public function akun()
    {
        return $this->belongsTo(\App\Models\User::class, 'akun_id');
    }
}

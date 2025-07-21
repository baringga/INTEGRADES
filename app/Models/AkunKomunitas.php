<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunKomunitas extends Model
{
    protected $table = 'akun_komunitas';
    public $timestamps = false;
    protected $fillable = ['akun_id', 'portofolio'];

    protected $primaryKey = 'akun_id';
    public $incrementing = false;

    public function create()
    {
        $user = Auth::user();
        $profilVolunteer = \App\Models\AkunKomunitas::where('akun_id', $user->id)->first();

        // Cek portofolio: harus ada dan tidak kosong setelah trim
        if (!$profilVolunteer || trim($profilVolunteer->portofolio) === '') {
            return redirect()->route('profil')->with('error', 'Harap lengkapi URL portofolio Anda di profil sebelum membuat campaign.');
        }

        return view('TambahCampaign');
    }
}

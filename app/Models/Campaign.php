<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaign';
    protected $fillable = [
        'akun_id',
        'nama',
        'waktu',
        'deskripsi',
        'lokasi',
        'kontak',
        'kuota_partisipan',
        'latitude',
        'longitude'
    ];

    // Mapping kolom timestamp ke nama kolom yang kamu gunakan di tabel
    const CREATED_AT = 'waktu';
    const UPDATED_AT = 'waktu_diperbarui';

    public function coverImage()
    {
        return $this->hasOne(GambarCampaign::class, 'campaign_id')->where('isCover', true);
    }
    public function partisipanCampaigns()
    {
        return $this->hasMany(\App\Models\PartisipanCampaign::class, 'campaign_id');
    }
    public function gambar_campaign()
    {
        return $this->hasMany(GambarCampaign::class, 'campaign_id');
    }
    public function akun()
    {
        return $this->belongsTo(\App\Models\User::class, 'akun_id');
    }
}

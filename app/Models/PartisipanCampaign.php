<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartisipanCampaign extends Model
{
    protected $table = 'partisipan_campaign';
    protected $fillable = [
        'akun_id', 'campaign_id', 'nama', 'email', 'nomorTelepon', 'motivasi'
    ];

    public $timestamps = false; // Tambahkan baris ini

    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class, 'campaign_id');
    }

    public function akun()
    {
        return $this->belongsTo(\App\Models\User::class, 'akun_id');
    }
}

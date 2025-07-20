<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarCampaign extends Model
{
    protected $table = 'gambar_campaign';
    public $timestamps = false;
    protected $fillable = ['campaign_id', 'gambar', 'isCover'];

    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class, 'campaign_id');
    }
    
    public function gambar_campaign()
    {
        return $this->hasMany(GambarCampaign::class, 'campaign_id');
    }
}

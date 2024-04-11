<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapanganDetail extends Model
{
    use HasFactory;

    protected $table = 'lapangan_detail';
    protected $guarded = [];

    
    public function lapangan(){
        return $this->belongsTo(Lapangan::class);
    }
    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }


}

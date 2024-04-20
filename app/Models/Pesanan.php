<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $guarded = [];

    public function lapangan_detail(){
        return $this->belongsTo(LapanganDetail::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
    }

    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }
    public function objek_wisata()
    {
        return $this->belongsToMany(Travel::class, 'pesanan_pantai', 'pesanan_id', 'objek_wisata_id');
    }
}

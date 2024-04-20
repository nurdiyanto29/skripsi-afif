<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjekWisata extends Model
{
    use HasFactory;

    protected $table = 'objek_wisata';
    protected $guarded = [];

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class, 'pesanan_pantai', 'objek_wisata_id', 'pesanan_id');
    }
}

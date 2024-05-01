<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $guarded = [];

    function foto_pembayaran()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('flag', 'foto_pembayaran');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function pesanan(){
        return $this->belongsTo(Pesanan::class);
    }
}

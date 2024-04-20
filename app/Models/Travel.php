<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $table = 'travel';
    protected $guarded = [];

    // public static $transmisi = ['Otomatis', 'Manual'];
    // public static $jenis = ['Mpv', 'Hackback', 'Suv'];

    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }

    function foto_travel()
    {
        return $this->morphMany(Attachment::class, 'attachable')->where('flag', 'foto_travel');
    }

}

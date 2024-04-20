<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    use HasFactory;

    protected $table = 'sopir';
    protected $guarded = [];


    function foto_sopir()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('flag', 'foto_sopir');
    }



    public function getUmurAttribute()
    {
        // Mengambil tanggal lahir dari kolom 'tanggal_lahir'
        $tanggal_lahir = $this->tanggal_lahir;
        // Menghitung tahun sekarang
        $tahun_sekarang = date('Y');

        // Menghitung tahun kelahiran
        $tahun_lahir = date('Y', strtotime($tanggal_lahir));

        // Menghitung umur
        $umur = $tahun_sekarang - $tahun_lahir;

        return $umur;
    }
    public function getJkAttribute()
    {
        $jenis_kelamin = $this->jenis_kelamin;
        if ($jenis_kelamin === 'P') {
            return 'Perempuan';
        }

        if ($jenis_kelamin === 'L') {
            return 'Laki-laki';
        }

        return null; // atau 'Jenis kelamin tidak valid'
    }
    public function travel()
    {
        return $this->hasOne(Travel::class);
    }
}

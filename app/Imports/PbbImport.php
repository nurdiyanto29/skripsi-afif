<?php

namespace App\Imports;

use App\Models\Pbb;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PbbImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 3;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nama = $row[1]??null;
        $alamat = $row[2]??null;
        $nomor_sppt = $row[3]??null;
        $jumlah_sppt = $row[4]??null;
    
        if(!$nama || !$nomor_sppt) return;
    
        return new Pbb([
            'nama'  => $nama,
            'alamat' => $alamat,
            'nomor_sppt' => $nomor_sppt,
            'jumlah_sppt' => $jumlah_sppt,
            
        ]);
    }

}

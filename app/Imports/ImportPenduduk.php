<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPenduduk implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $dusun_id = '';
        if ($row[3] == 'BERAN KIDUL') $dusun_id = '447bc841-582b-47a1-b940-47ee677f34ba';
        if ($row[3] == 'WADAS') $dusun_id = '4cd87c20-df8c-43ec-9aae-4b8b21218bd1';
        if ($row[3] == 'NGEMPLAK CABAN') $dusun_id = '59605a28-6bac-4392-b684-a623c75ea562';
        if ($row[3] == 'BERAN LOR') $dusun_id = '5a2fa24e-23fa-4080-b1f3-653ed9595c1d';
        if ($row[3] == 'PATEN') $dusun_id = '679bc51a-c4ab-4b54-9154-0b36defcf49c';
        if ($row[3] == 'JABAN') $dusun_id = '7667412c-f9b6-42db-a4a2-c8da1611f716';
        if ($row[3] == 'JOSARI') $dusun_id = '7992eca5-5d97-4feb-aa89-07a299ae5275';
        if ($row[3] == 'BETENG') $dusun_id = '874e3778-0564-4ec4-9360-dcae9227fff6';
        if ($row[3] == 'DENGGUNG') $dusun_id = '8bae77fd-bea6-4c74-b8d2-db01b8c75e5e';
        if ($row[3] == 'BANGUNREJO') $dusun_id = '94e0451b-5cd5-4fa8-b155-f80b320231ee';
        if ($row[3] == 'DRONO') $dusun_id = 'aa1e6b2a-3aed-4e07-8896-a56942bdf07f';
        if ($row[3] == 'DUKUH') $dusun_id = 'ce725c38-fe63-45d6-9710-7d328404e4e5';
        if ($row[3] == 'PANGUKAN') $dusun_id = 'ec377c68-c64c-4e0f-bb43-7b4c471e4e65';
        if ($row[3] == 'PISANGAN') $dusun_id = 'fbe11a04-0675-48dc-903a-69d497c9edf7';
        if ($row[3] == 'KEBONAGUNG') $dusun_id = 'ffe57450-f8eb-4311-88c6-7223f5d6e853';

        $input = $row[9];
        $unixDate = ($input - 25569) * 86400;
        $date = date("Y-m-d", $unixDate);

        return new Penduduk([
            'dusun_id' => $dusun_id ? $dusun_id : '-',
            'nik' => $row[0],
            'kk' => $row[2],
            'nama' => $row[1],
            'rw' => $row[4],
            'rt' => $row[5],
            'pendidikan' => $row[6],
            'pendidikan_ditempuh' => $row[7],
            'pekerjaan' => $row[8],
            'tanggal_lahir' => $date,
            'kawin' => $row[12] ?? '-',
            'hub_keluarga' => $row[13] ?? '-',
            'gol_darah' => $row[14] ?? '',
            'nama_ayah' => $row[15] ?? '-',
            'nama_ibu' => $row[16] ?? '-',
            'status' => $row[17] ?? '-',
            'agama' => $row[18] ?? '-',
            'jk' => $row[19] ?? '-',
        ]);
    }
}

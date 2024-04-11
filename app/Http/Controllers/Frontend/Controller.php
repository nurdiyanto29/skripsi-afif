<?php

namespace App\Http\Controllers\Frontend;

use App\Models\SocialMedia;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\Paginator;
// use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;

    function view($path,$data){
        Paginator::useBootstrapFour();
        
        $data += [
            '_setting' => config('tridadi'),
            'sosmed' => SocialMedia::all(),
            'menu_container' => [
                'beranda' => '/',
                'pemerintahan' =>[
                    'Visi & Misi' => '/konten/visi_misi',
                    'Profil dan Peta wilayah' => '/konten/profil_dan_wilayah',
                    'Pamong Kelurahan' => '/konten/pamong_kalurahan',
                    'Lurah' => '/konten/kepala_desa',
                    'Badan Permusyawaratan' => '/konten/badan_permusyawaratan',
                    'Produk Hukum' => '/produk_hukum',
                    'Sejarah Kalurahan' => '/konten/sejarah_kalurahan',
                    'Gambaran Umum' => '/konten/gambaran_umum',
                    'Padukuhan' => '/padukuhan',
                    'Potensi' => '/post/potensi'
                ],
               
                'Kemasyarakatan' => [
                    'Data ODGJ' => '/odgj',
                    'Data Kamling' => '/kamling',
                    'LKK' => '/post/lkk'
                ],
                'Pembangunan' => [
                    'Data Pajak PBB' => '/pbb',
                    'Data UMKM' => '/umkm'
                ],

                'Media' => [    
                    'Berita' => '/post/berita',
                    'Agenda' => '/agenda',
                    'Video' => '/video'
                ],

                'Layanan' => [
                    'Layanan kesehatan' => '/konten/layanan_kesehatan',
                    'Layanan Pindah Penduduk' => '/konten/layanan_pindah_penduduk',
                    'Layanan Masuk Penduduk' => '/konten/layanan_masuk_penduduk',
                    'Layanan Surat Keterangan' => '/konten/layanan_surat_keterangan',
                    'Layanan Surat Kematian' => '/konten/layanan_surat_kematian',
                    'Layanan Pengurusan KK' => '/konten/layanan_pengurusan_kk',
                    'Layanan Pengurusan KTP' => '/konten/layanan_pengurusan_ktp',
                ],


                'Data' => [
                    'Data wilayah' => '/dusun',
                    'Data pendidikan' => '/data_desa/pendidikan',
                    'Data pendidikan yang ditempuh' => '/data_desa/pendidikan_yang_ditempuh',
                    'Data pekerjaan' => '/data_desa/pekerjaan',
                    'Data Agama' => '/data_desa/agama',
                    'Jenis kelamin' => '/data_desa/jenis_kelamin',
                    'Golongan darah' => '/data_desa/golongan_darah',
                    'Kelompok umur' => '/data_desa/kelompok_umur',
                    'Status perkawinan' => '/data_desa/status_perkawinan',
                ],

                'Kritik & Saran' => [
                    'Kotak Saran' => '/kotak_saran?_t=kotak_saran',
                    'Jaring Asmara BPKal' => '/kotak_saran?_t=jaring_asmara',
                ]
            ],

            
            'menu_footer' =>[
                'Tentang Kami' => [
                    'Sejarah Kalurahan' => '/konten/sejarah_kalurahan',
                    'Profil dan Peta wilayah' => '/konten/profil_dan_wilayah',
                    'Gambaran Umum' => '/konten/gambaran_umum',
                    'Potensi' => '/post/potensi'
                ],

                'Media' => [    
                    'Berita' => '/post/berita',
                    'Agenda' => '/agenda',
                    'Video' => '/video'
                ],

                'Layanan' => [
                    'Layanan kesehatan' => '/konten/layanan_kesehatan',
                    // 'Layanan kesehatan' => '/konten/layanan_kesehatan',
                    'Layanan Pindah Penduduk' => '/konten/layanan_pindah_penduduk',
                    'Layanan Masuk Penduduk' => '/konten/layanan_masuk_penduduk',
                    'Layanan Surat Keterangan' => '/konten/layanan_surat_keterangan',
                    'Layanan Surat Kematian' => '/konten/layanan_surat_kematian',
                    'Layanan Pengurusan KK' => '/konten/layanan_pengurusan_kk',
                    'Layanan Pengurusan KTP' => '/konten/layanan_pengurusan_ktp',
                ],

                'Kritik & Saran' =>[
                    'Kotak Saran' => '/kotak_saran?_t=kotak_saran',
                    'Jaring Asmara' => 'kotak_saran?_t=jaring_asmara'
                ]


            ],

        ];
        // dd($data);
        return view($path,$data);
    }


}

<?php


return [
    'telegram_chat' => [
        'default' => env('TELEGRAM_CHAT_DEFAULT'),
        'error' => null,
    ],
    'permission' => [

        'admin' => [
            'agenda',
            'dusun',
            'kamling',
            'kategori',
            'kotak_saran',
            'odgj',
            'pbb',
            'penduduk',
            'permission',
            'produk_hukum',
            'role',
            'social_media',
            'umkm',
            'user',
            'video',
            'visi_misi',

            'badan_permusyawaratan',
            'gambaran_umum',
            'profil_dan_wilayah',
            'kepala_desa',
            'sejarah_kalurahan',
            'layanan_kesehatan',
            'pamong_kalurahan',
            
            'berita',
            'lkk',
            'postensi',

            // 'settings', //untuk setting nanti dipecah lagi dan belum tau cara mangilnya. mungkin di beri tambahan permission (yang sebelumnya selalu mengambil nama model)

        ],

    ],
    'guardname' => [
        'admin',
    ]

];

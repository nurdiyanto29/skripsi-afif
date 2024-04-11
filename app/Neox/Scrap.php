<?php
namespace App\Neox;

use Carbon\Carbon;
use App\Models\Post;
use Symfony\Component\DomCrawler\Crawler;

class Scrap {

    static $post    = [];
    static $success = 0;
    static $error_msg;
    static $status = true;

    static function get_data($num=1) {

        static::run($num);
        return [
            'status' => static::$status,
            'data'   => static::$success,
            'error'  => static::$error_msg,
        ];
    }

    static function run($num) {

        try {
            $goutte  = new \Goutte;
            $web     = 'https://tridadisid.slemankab.go.id/first/index/'.$num;
            $crawler = $goutte::request('GET', $web);

            foreach($crawler->filter('ul.artikel-list li.artikel') as $crw){
                $node = new Crawler($crw);

                $link    = $node->filter('.judul a')->link()->getUri();
                $judul   = trim($node->filter('.judul a')->text(''));
                if(!$judul) continue;

                $post_cek = Post::where('tipe','berita')->where('judul', $judul)->first();
                if($post_cek) continue;

                $item    = $goutte::request('GET', $link);
                $section = $item->filter('#contentcolumn .innertube .artikel');

                $tanggal  = static::convert_date($section->filter('.kecil')->html());
                
                $teks     = $section->filter('.teks')->html();
                if(!$teks) continue;

                static::save([
                    'judul' => $judul,
                    'deskripsi' => $teks,
                    'tipe' => 'berita',
                    'created_at' => $tanggal,
                    'foto' => '',
                ], $section);            
            
            }

        } catch (\Throwable $er) {
            static::$status = false;
            static::$error_msg = $er->getMessage();
        }
    }
    
    static function save($post,$section){
        try {
            $img = static::download_foto( $section->filter('.sampul a')->attr('href') );
            $post['foto'] = $img;
        } catch (\Throwable $th) {
        }
        Post::create($post);
        static::$success++;

    }

    static function download_foto($link){
        $tipe = 'berita';
        $cek = @getimagesize($link);
        if(!($cek['mime']??null)) return;

        $ext = mime_to_ext($cek['mime']) ?:'.jpg';
        $nm = uniqid();
        $path = $tipe.'/'.$nm.$ext;

        $counter = 1;
        while(file_exists(public_path().'/files/'.$path)){
            $path = $tipe.'/'.$nm.'_'.$counter.$ext;
            $counter++;
        }

        $thumb = str_replace($tipe.'/',$tipe.'/thumb_',$path);
        // dd($path,$thumb);

        $img = @file_get_contents($link);
        if(!$img) return;

        $image = \Image::make($img);

        $img = $image->save('files/'.$path,60);
        $image->fit(524, 360)->save('files/'.$thumb,100);

        return $img ? $path : null;
        
    }

    static function convert_date($val) {
        $curent = date('Y-m-d H:i:s');
        $val = trim (  str_replace('WIB','',(explode('<i class="fa fa-clock-o"></i>', $val)[1] ?? null ) )    );
        $date = explode(" ",$val);

		if(count($date) < 3) return $curent;

		$tgl   = $date[0];
		$bulan = strtolower($date[1]);
		$thn   = $date[2];
		$time  = ((isset($date[3])) ? ' '.$date[3] : '');

		switch($bulan){
			case "januari": $bln = "01"; break;
			case "februari": $bln = "02"; break;
			case "maret": $bln = "03"; break;
			case "april": $bln = "04"; break;
			case "mei": $bln = "05"; break;
			case "juni": $bln = "06"; break;
			case "juli": $bln = "07"; break;
			case "agustus": $bln = "08"; break;
			case "september": $bln = "09"; break;
			case "oktober": $bln = "10"; break;
			case "november": $bln = "11"; break;
			case "desember": $bln = "12"; break;
			default : $bln = ''; break;
		}
        
        $out = "$thn-$bln-$tgl".$time;

        try {
            Carbon::parse($out);
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            $out = null;
        }
		return $out ?: $curent; 
       
    }

}
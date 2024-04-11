<?php

namespace App\Console\Commands;

use App\Models\BarangDetail;
use App\Models\Pesanan;
use App\Models\WaitingList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Telegram\Bot\Laravel\Facades\Telegram;

class BatasBayarCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batasbayar:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron batas pembayaran ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Pesanan::whereDoesntHave('pembayaran')
                         ->where('created_at', '<=', Carbon::now()->subMinutes(5))
                         ->get();

        foreach ($orders as $order) {
            $order->delete();
        }

        $this->info('Pesanan Di hapus.');
    }
}

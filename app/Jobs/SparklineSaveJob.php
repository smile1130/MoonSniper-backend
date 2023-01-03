<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SparklineSaveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $coins;
    public function __construct($coins)
    {
        $this->coins = $coins;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->coins as $key => $coin) {
            try {
                $html = file_get_contents('https://www.coingecko.com/coins/'.$coin.'/sparkline');
                Storage::put('public/sparklineicon/sparkline_'.$coin.'.svg', $html);
            } catch (\Throwable $th) {
                 sleep(20);
                 Log::info("Chart Data: $th");
                 $html = file_get_contents('https://www.coingecko.com/coins/'.$coin.'/sparkline');
                 Storage::put('public/sparklineicon/sparkline_'.$coin.'.svg', $html);
                 
            }
           

        }//
    }
}
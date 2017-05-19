<?php

namespace App\Console\Commands;

use App\Helper\EncryptHelper;
use App\Helper\MessageHelper;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);

        //dump(MessageHelper::send_sms('016792636157878', 'Test'));
    }
}

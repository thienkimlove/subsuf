<?php

namespace App\Console\Commands;

use App\Helper\EncryptHelper;
use App\Helper\MessageHelper;
use App\Order;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Jenssegers\Optimus\Optimus;

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

        //dump(MessageHelper::send_sms_vt('01679263615', 'Test nha'));
        
        $orders = Order::all();

        foreach ($orders as $order) {
            $id = $order->order_id;

            $optimus = new Optimus(1580030173, 59260789, 1163945558);

            $code = $optimus->encode($order->order_id);

            Order::find($id)->update([
                'code' => $code
            ]);
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OrderDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:dispatch {sid} {eid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order dispatch';

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
     * @return mixed
     */
    public function handle()
    {
	   $startID = intval($this->argument('sid'));
	   $endID = intval($this->argument('eid'));

	   if ($startID > $endID) {
	   	    $this->error('argument error: sid must lt eid');
	   	    exit(1);
	   }

	   $this->info("start handle order");
	   $bar = $this->output->createProgressBar(100);
	   sleep(1);
	   $bar->advance();
	   $this->handleOrder($startID, $endID);
	   $bar->finish();
	   $this->info('order handle finished');
    }


    public function handleOrder($startID, $endID)
    {

	    \DB::table('shop_order')->where('is_on', 1)
		    ->select(['id'])
		    ->where('is_deal_provide', 0)           //'是否已处理供应商'
		    ->where('id', '>=', $startID)
		    ->where('id', '<=', $endID)
		    ->whereRaw('(type = 1 or type = 4)')                //订单类型:1,零售订单;2,物料订单;3,自提订单;4,补货订单
		    ->orderBy('id')
		    ->chunk(100, function ($orders) {

			    foreach ($orders as $order) {
				    \Log::info('处理'.$order->id);
				    try {
					    \App\Logic\Api\ShopOrderLogic::dealOrderSupplier($order->id);
					    \Log::info('订单:'.$order->id. '已处理');
				    } catch (\Exception $e) {
					    \Log::error('订单:'.$order->id. '处理失败:'.$e->getMessage());
					    continue;
				    }
			    }

		    });

	    return true;

    }
}

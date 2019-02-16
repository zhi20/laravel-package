<?php

namespace App\Listeners;

use App\Events\AdminLogEvent;
use App\Model\BaseAdminLogModel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminLogEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminLogEvent  $event
     * @return void
     */
    public function handle(AdminLogEvent $event)
    {
        //
        $data = $event->getData();
        $model = new BaseAdminLogModel();
        $model->setValue($data);
        $model->save();
    }
}

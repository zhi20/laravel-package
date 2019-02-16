<?php

namespace App\Listeners;

use App\Events\ErrorLogEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ErrorLogEventListener
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
     * @param  ErrorLogEvent  $event
     * @return void
     */
    public function handle(ErrorLogEvent $event)
    {
        //
        $data = $event->getData();
        $model = new ErrorLogModel();
        $model->setValue($data);
        $model->save();
    }
}

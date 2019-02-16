<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $data = [];
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        //
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }

    public function setData($key, $value){
        if(is_array($key)){
            $this->data = array_merge($this->data,$key);
        }else{
            $this->data[$key] = $value;
        }
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('channel-name');
    }
}

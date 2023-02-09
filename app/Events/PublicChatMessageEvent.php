<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class PublicChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->dontBroadcastToCurrentUser();
        $this->message = $message;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PresenceChannel
     */
    public function broadcastOn(): Channel|PresenceChannel
    {
        return new PresenceChannel('public-chat');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return ['user_id' => Auth::user()->id,'message'=>$this->message,'name'=> Auth::user()->name];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class FriendsCountUpdateEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $counts;
    public \Illuminate\Contracts\Auth\Authenticatable|null|\App\Models\User $user;

    public function __construct()
    {
        $this->user = Auth::user();
//        c= [
//            'friends' => $this->user->friends()->count(),
//            'pending' => $this->user->friendPendingRequest()->count(),
//            'request' => $this->user->friendRequest()->count(),
//        ];

        $this->counts = ['asd'];
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('friendsListUpdate');
    }

    public function broadcastWith(): array
    {
        return $this->counts;
    }
}

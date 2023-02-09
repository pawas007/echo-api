<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendPending extends Model
{
    protected $fillable = ['user_id', 'pending_friend_id'];
}

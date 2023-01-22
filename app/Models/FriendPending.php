<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendPending extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'pending_friend_id'];
}

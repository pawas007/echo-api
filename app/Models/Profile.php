<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable =
        [
            'country',
            'sex',
            'avatar',
            'avatar_url',
            'user_id',
            'region',
            'city',
            'locality',
            'poster',
            'about',
            'quote',
            'birthday'
        ];

    protected $hidden = ['id', 'created_at', 'updated_at', 'user_id', 'pivot'];
}

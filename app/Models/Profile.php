<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    const sex = ['Male', 'Female'];

    protected $fillable =
        [
            'country',
            'age',
            'sex',
            'avatar',
            'avatar_url',
            'user_id',
            'address',
            'poster',
            'about',
            'quote',
            'birthday'
        ];

    protected $hidden = ['id', 'created_at', 'updated_at', 'user_id', 'pivot'];
}

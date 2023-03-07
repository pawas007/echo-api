<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{


    const age = ['0-17', '18-29', '30-54', '54+'];
    const sex = ['Male', 'Female'];

    protected $fillable = ['country', 'age', 'sex', 'avatar', 'avatar_url', 'user_id'];

    protected $hidden = ['id','created_at','updated_at','user_id','pivot'];
}

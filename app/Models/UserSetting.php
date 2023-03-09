<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class UserSetting extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'user_setting';
    protected $fillable =['notifications','user_id'];

}

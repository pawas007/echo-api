<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class UserSetting extends Model
{
    /**
     * @var mixed|string
     */
    public mixed $name;
    protected $connection = 'mongodb';
    protected $collection = 'user_settings';
    protected $fillable = ['user_id','settings'];
}

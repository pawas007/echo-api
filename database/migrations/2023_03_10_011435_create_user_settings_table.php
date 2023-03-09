<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    protected $connection = 'mongodb';

    public function up()
    {
        Schema::connection($this->connection)->drop('user_setting');
        Schema::connection($this->connection)->create('user_setting', function ($collection) {
            $collection->integer('user_id');
            $collection->json('notifications');
        });

    }
};

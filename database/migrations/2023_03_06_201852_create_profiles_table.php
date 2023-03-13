<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('country')->nullable();
            $table->string('age')->nullable();
            $table->string('address')->nullable();
            $table->string('sex')->nullable();
            $table->string('avatar')->nullable();
            $table->string('poster')->nullable();
            $table->text('about')->nullable();
            $table->text('quote')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};

//$table->id();
//$table->integer('user_id');
//$table->string('code');
//$table->timestamps();
//
//$table->id();
//$table->integer('user_id');
//$table->string('token');
//$table->timestamps();

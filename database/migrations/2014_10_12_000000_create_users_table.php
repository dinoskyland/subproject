<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',30);
            $table->string('last_name',15);
            $table->string('phone_no',15);            
            $table->string('email',150)->unique();
            $table->string('address',30);
            $table->string('suburb',20);
            $table->string('description',20);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('register_id',15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

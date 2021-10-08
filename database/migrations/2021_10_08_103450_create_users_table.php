<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('first_name', 32)->nullable();
            $table->string('last_name', 32)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->string('phone', 15)->nullable();
            $table->string('image')->default('no_image.jpg');
            $table->string('pen_code', 50)->nullable();
            $table->string('verifycode');
            $table->enum('role', ['0', '1', '2']);
            $table->string('user_role', 50)->nullable();
            $table->rememberToken();
            $table->timestamps();
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

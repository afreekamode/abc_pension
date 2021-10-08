<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('employer_name', 100)->nullable();
            $table->string('employer_code', 100)->nullable();
            $table->string('nok_phone', 100)->nullable();
            $table->string('nok_fname', 100)->nullable();
            $table->string('nok_lname', 100)->nullable();
            $table->string('nok_email', 100)->nullable();
            $table->integer('profile_status')->default(0);
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
        Schema::dropIfExists('employees');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensionCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pension_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('transactions_id', 36);
            $table->string('user_id');
            $table->string('pen_code');
            $table->integer('pen_code_type')->nullable();
            $table->dateTime('pen_code_ttl');
            $table->string('pen_code_status');
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
        Schema::dropIfExists('pension_code');
    }
}

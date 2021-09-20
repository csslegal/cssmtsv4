<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visa_file_id');
            $table->integer('user_id');
            $table->string('gwf');
            $table->string('name');//hesap
            $table->string('password');//hesap
            $table->string('date');//tarih
            $table->string('time');//saat
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
        Schema::dropIfExists('visa_appointments');
    }
}

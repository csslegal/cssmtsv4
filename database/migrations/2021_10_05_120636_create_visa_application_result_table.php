<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaApplicationResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_application_result', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('visa_file_id');
            $table->foreign('visa_file_id')->references('id')->on('visa_files')->onDelete('cascade');

            $table->integer('user_id');

            $table->string('visa_result')->nullable();
            $table->string('visa_start_date')->nullable();                      //vize başlangıc tarihi
            $table->string('visa_end_date')->nullable();                        //vize bitiş tarihi
            $table->string('visa_delivery_accepted_date')->nullable();          //vize teslim alınma tarihi

            $table->string('visa_refusal_reason')->nullable();
            $table->string('visa_refusal_date')->nullable();                    //ret verildiği tarih
            $table->string('visa_refusal_delivery_accepted_date')->nullable();  //ret teslim alınma tarihi

            $table->string('visa_file_close_date')->nullable();
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
        Schema::dropIfExists('visa_application_result');
    }
}

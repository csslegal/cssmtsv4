<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFileDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_file_delivery', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('visa_file_id');
            $table->foreign('visa_file_id')->references('id')->on('visa_files')->onDelete('cascade');

            $table->integer('application_office_id');
            $table->integer('user_id');

            $table->string('delivery_method');
            $table->string('courier_company');
            $table->string('tracking_number');

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
        Schema::dropIfExists('visa_file_delivery');
    }
}

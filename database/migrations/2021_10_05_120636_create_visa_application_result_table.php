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

            $table->integer('visa_file_id');
            $table->integer('user_id');

            $table->string('visa_result');
            $table->string('visa_date');
            $table->string('visa_refusal_reason');
            $table->string('visa_refusal_date');

            $table->string('visa_file_close_date');
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

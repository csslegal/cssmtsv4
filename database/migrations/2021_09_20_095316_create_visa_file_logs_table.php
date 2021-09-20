<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFileLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_file_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('visa_file_id')->nullable();
            $table->foreign('visa_file_id')->references('id')
                ->on('visa_files')->onDelete('cascade');

            $table->integer('user_id')->nullable(); //işlem yapan

            $table->string('subject');
            $table->text('content');

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
        Schema::dropIfExists('visa_file_logs');
    }
}

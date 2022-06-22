<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_translations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('visa_file_id');
            $table->foreign('visa_file_id')->references('id')->on('visa_files')->onDelete('cascade');

            $table->integer('user_id');
            $table->integer('page'); //sayfa
            $table->integer('word'); //kelime
            $table->integer('character'); //karakter
            $table->integer('translated_page'); //sayfa
            $table->integer('translated_word'); //kelime
            $table->integer('translated_character'); //karakter
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
        Schema::dropIfExists('visa_translations');
    }
}

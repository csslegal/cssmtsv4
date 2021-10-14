<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaRefusalTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_refusal_translation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visa_file_id');
            $table->integer('user_id');

            $table->string('page_count');
            $table->string('translate_page_count');
            $table->string('translate_word_count');
            $table->string('translate_character_count');

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
        Schema::dropIfExists('visa_refusal_translation');
    }
}

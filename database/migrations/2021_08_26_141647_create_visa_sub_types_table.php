<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_sub_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('visa_type_id')->nullable();
            $table->foreign('visa_type_id')->references('id')->on('visa_types')->onDelete('cascade');
            $table->string('name');
            $table->integer('orderby')->default(0);
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
        Schema::dropIfExists('visa_sub_types');
    }
}

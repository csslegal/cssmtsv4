<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_files', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')
                ->on('customers')->onDelete('cascade');

            $table->integer('visa_sub_type_id')->nullable(); //vize tipi
            $table->integer('visa_validity_id')->nullable(); //vize süresi
            $table->integer('visa_file_grades_id')->nullable(); //dosya aşaması
            $table->integer('temp_grades_id')->nullable(); //dosya aşaması geçiçi tutma

            $table->integer('advisor_id')->nullable();
            $table->integer('expert_id')->nullable();
            $table->integer('translator_id')->nullable();

            $table->integer('status')->default(0); //dosya durumu acil veya normal
            $table->integer('active')->default(1); //0 ise pasif arşiv
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
        Schema::dropIfExists('visa_files');
    }
}

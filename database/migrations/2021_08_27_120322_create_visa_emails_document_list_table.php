<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaEmailsDocumentListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_emails_document_list', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('language_id')->nullable();
            $table->foreign('language_id')->references('id')->on('language')->onDelete('cascade');

            $table->unsignedBigInteger('visa_sub_type_id')->nullable();
            $table->foreign('visa_sub_type_id')->references('id')->on('visa_sub_types')->onDelete('cascade');

            $table->text('content');
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
        Schema::dropIfExists('email_document_list');
    }
}

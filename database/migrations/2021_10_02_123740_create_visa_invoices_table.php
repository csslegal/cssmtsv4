<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visa_file_id');
            $table->integer('user_id');
            $table->string('payment');
            $table->string('matrah');
            $table->string('date');
            $table->string('number');
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
        Schema::dropIfExists('visa_invoices');
    }
}

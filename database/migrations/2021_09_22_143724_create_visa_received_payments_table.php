<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaReceivedPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_received_payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('visa_file_id');
            $table->foreign('visa_file_id')->references('id')->on('visa_files')->onDelete('cascade');

            $table->integer('user_id');
            $table->string('name');
            $table->string('received_tl')->nullable();
            $table->string('received_euro')->nullable();
            $table->string('received_dolar')->nullable();
            $table->string('received_pound')->nullable();
            $table->string('payment_total');
            $table->string('payment_method', 20);
            $table->string('payment_date', 20);
            $table->integer('confirm')->default(0);
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
        Schema::dropIfExists('visa_received_payments');
    }
}

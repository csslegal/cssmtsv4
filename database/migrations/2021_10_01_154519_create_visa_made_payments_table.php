<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaMadePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_made_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visa_file_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('made_tl')->nullable();
            $table->string('made_euro')->nullable();
            $table->string('made_dolar')->nullable();
            $table->string('made_pound')->nullable();
            $table->string('payment_total');
            $table->string('payment_method', 20);
            $table->string('payment_date', 20);
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
        Schema::dropIfExists('visa_made_payments');
    }
}

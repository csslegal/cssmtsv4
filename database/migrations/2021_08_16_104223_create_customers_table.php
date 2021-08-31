<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('application_office_id')->nullable();
            $table->integer('appointment_office_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('tcno')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('telefon');
            $table->string('adres')->nullable();
            $table->string('pasaport')->nullable();
            $table->string('pasaport_tarihi', 20)->nullable();
            $table->integer('bilgilendirme_onayi')->default(1);

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
        Schema::dropIfExists('customers');
    }
}

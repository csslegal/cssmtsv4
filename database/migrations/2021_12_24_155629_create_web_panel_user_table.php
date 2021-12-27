<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPanelUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_panel_user', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('panel_auth_id')->nullable();
            $table->foreign('panel_auth_id')->references('id')->on('web_panel_auth')->onDelete('cascade');

            $table->unsignedBigInteger('panel_id')->nullable();
            $table->foreign('panel_id')->references('id')->on('web_panels')->onDelete('cascade');

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
        Schema::dropIfExists('web_panel_user');
    }
}

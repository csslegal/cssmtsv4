<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFileGradesUsersTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_file_grades_users_type', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_type_id');
            $table->unsignedBigInteger('visa_file_grade_id');

            $table->foreign('user_type_id')->references('id')
                ->on('users_type')->onDelete('cascade');


            $table->foreign('visa_file_grade_id')->references('id')
                ->on('visa_file_grades')->onDelete('cascade');

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
        Schema::dropIfExists('visa_file_grades_access');
    }
}

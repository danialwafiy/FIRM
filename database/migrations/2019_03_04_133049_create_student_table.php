<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->string('student_id')->unique();
            $table->integer('status');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('faculty');
            $table->string('course');
            $table->string('intern_start_date');
            $table->string('intern_end_date');
            $table->string('semester');
            $table->string('company_name');
            $table->string('company_address');
            $table->integer('company_postcode');
            $table->string('company_city');
            $table->string('company_state');
            $table->string('company_phone');  
            $table->string('supervisor_id');
            $table->string('supervisor_name');
            $table->string('meeting_date');  
            $table->string('meeting_status');
            $table->string('meeting_msg');
            $table->string('lecture_id_FK')->default('');
            $table->rememberToken();
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
        Schema::dropIfExists('student');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->increments('logbook_id')->unique();
            $table->string('title');
            $table->longText('description');
            $table->integer('week');
            $table->date('date');
            $table->string('filename')->nullable();
            $table->string('lecture_verify')->default('unverified');
            $table->string('supervisor_verify')->default('unverified');
            $table->string('student_id_FK');
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
        Schema::dropIfExists('logbook');
    }
}

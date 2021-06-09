<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('nis');
            $table->unsignedBigInteger('room');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->foreign('nis')
                ->references('username')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('room')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

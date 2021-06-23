<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->unsignedBigInteger('assignment_id');
            $table->string('description')->nullable();
            $table->string('file')->nullable();
            $table->foreign('nis')
                ->references('nis')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('assignment_id')
                ->references('id')
                ->on('assignments')
                ->onDelete('cascade');
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
        Schema::dropIfExists('submissions');
    }
}

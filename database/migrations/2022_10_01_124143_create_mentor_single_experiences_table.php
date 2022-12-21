<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorSingleExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_single_experiences', function (Blueprint $table) {
            $table->id();
            $table->integer('mentor_id');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->boolean('date_present')->default(0);
            $table->string('company')->nullable();
            $table->string('position')->nullable();
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
        Schema::dropIfExists('mentor_single_experiences');
    }
}

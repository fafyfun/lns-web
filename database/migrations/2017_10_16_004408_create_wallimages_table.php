<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWallimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallimages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->unsignedInteger('wall_id');
            $table->foreign('wall_id')->references('id')->on('walls');
            $table->unique(['image', 'wall_id']);
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
        Schema::dropIfExists('wallimages');
    }
}

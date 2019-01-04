<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_id');
            $table->string('subject_type');
            $table->string('name');
            $table->string('key_name');
            $table->unsignedInteger('auth_id');
            $table->string('auth_type');
            $table->index(['subject_id','subject_type','auth_id','auth_type']);
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
        Schema::table('activities', function(Blueprint $table) {

            //$table->dropIndex('activities_subject_id_subject_type_authenticator_id_authenticator_type_index');
        });
        Schema::dropIfExists('activities');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quotationjob_id');
            $table->foreign('quotationjob_id')->references('id')->on('quotationjobs');
            $table->unsignedInteger('installationlead_id');
            $table->foreign('installationlead_id')->references('id')->on('users');
            $table->timestamp('planned_delivery_date_time');
            $table->timestamp('actual_delivery_date_time')->nullable();
            $table->enum('status', ['1','2','3','4','5'])->comment('1-Pending 2-Visited 3-Partially Completed 4-Completed 5-Cancelled');
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
        Schema::dropIfExists('installations');
    }
}

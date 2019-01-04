<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('saleslead_id');
            $table->foreign('saleslead_id')->references('id')->on('salesleads');
            $table->unsignedInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users');
            $table->timestamp('planned_visit_date_time');
            $table->enum('inquiry_source', ['1', '2'])->comment('1-Internal 2-External');
            $table->mediumInteger('maximum_discount');
            $table->timestamp('actual_visit_date_time');
            $table->string('cancel_reason')->nullable();
            $table->enum('status', ['1', '2','3'])->comment('1-Assigned 2-Visited 3-Cancelled');
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('inquiries');
    }
}

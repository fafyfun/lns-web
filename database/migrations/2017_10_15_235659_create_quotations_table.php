<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inquiry_id');
            $table->foreign('inquiry_id')->references('id')->on('inquiries');
            $table->decimal('installation_fee', 10, 2);
            $table->decimal('transport_fee', 10, 2);
            $table->decimal('removable_fee', 10, 2);
            $table->decimal('cleaning_fee', 10, 2);
            $table->decimal('other_fee', 10, 2);
            $table->mediumInteger('discount');
            $table->decimal('total_cost', 10, 2);
            $table->decimal('total_cost_country', 10, 2);
            $table->enum('status', ['1','2','3'])->comment('1-Confirmed 2-Approved 3-Cancelled');
            $table->enum('latest', ['1','0'])->comment('1-True 0-False');
            $table->mediumInteger('revision_no');
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
        Schema::dropIfExists('quotations');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->enum('published', ['Y', 'N'])->comment('Y-Yes N-No');
            $table->enum('uom', ['1', '2'])->comment('1-Square Feet 2-Linear Length');
            $table->decimal('unit_price',10,2);
            $table->string('image');
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
        Schema::dropIfExists('products');
    }
}

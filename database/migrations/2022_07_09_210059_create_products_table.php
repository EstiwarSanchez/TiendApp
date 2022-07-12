<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->unique();
            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->references('id')->on('sizes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('observations',250)->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('inventory_quantity')->nullable();
            $table->timestamp('boarding_date');
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
};

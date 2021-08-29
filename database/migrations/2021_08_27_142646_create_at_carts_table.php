<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('at_carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ref_cart_id');
            $table->uuid('ref_product_id');
            $table->unsignedSmallInteger('qty')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('subtotal_price')->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';

            $table->foreign('ref_cart_id')
            ->on('t_carts')
            ->references('id')
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
        Schema::dropIfExists('at_carts');
    }
}

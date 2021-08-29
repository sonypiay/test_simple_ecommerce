<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('at_transactions', function (Blueprint $table) {
            $table->uuid('ref_transaction_id');
            $table->uuid('ref_product_id');
            $table->unsignedSmallInteger('qty')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('subtotal_price')->default(0);
            $table->unsignedTinyInteger('sort');

            $table->engine = 'InnoDB';

            $table->foreign('ref_transaction_id')
            ->on('t_transactions')
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
        Schema::dropIfExists('at_transaction');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_id', 20)->unique();
            $table->uuid('ref_user_id');
            $table->unsignedInteger('total_price')->default(0);
            $table->unsignedSmallInteger('total_item')->default(0);
            $table->json('address_info');
            $table->timestamps();

            $table->engine = 'InnoDB';

            $table->foreign('ref_user_id')
            ->on('t_users')
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
        Schema::dropIfExists('t_transactions');
    }
}

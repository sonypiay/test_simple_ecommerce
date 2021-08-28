<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('product_code', 10)->unique();
            $table->string('product_name', 128);
            $table->string('product_image', 128);
            $table->unsignedInteger('price')->default(0);
            $table->enum('publish', ['Y', 'N'])->default('Y');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_product');
    }
}

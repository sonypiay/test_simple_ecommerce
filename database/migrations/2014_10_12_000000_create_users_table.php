<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('email');
            $table->string('password');
            $table->enum('publish', ['Y', 'N'])->default('Y');
            $table->enum('roles', ['admin', 'user']);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique(['email', 'roles']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

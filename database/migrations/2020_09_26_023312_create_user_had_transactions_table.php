<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHadTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_had_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('transactions_id');
            $table->integer('users_id');
            $table->integer('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->foreign('transactions_id')->references('id')->on('transactions');
            $table->foreign('users_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_had_transactions');
    }
}

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('desc');
            $table->string('debit');
            $table->string('credit');
            $table->integer('wallets_id');
            $table->integer('bids_id')->nullable();
            $table->integer('statuses_id')->nullable();
            $table->integer('transaction_type_id');
            $table->foreign('wallets_id')->references('id')->on('wallets');
            $table->foreign('bids_id')->references('id')->on('bids');
            $table->foreign('statuses_id')->references('id')->on('statuses');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
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
        Schema::dropIfExists('transactions');
    }
}

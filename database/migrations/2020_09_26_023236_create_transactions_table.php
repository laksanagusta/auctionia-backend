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
            $table->string('grandtotal');
            $table->string('subtotal');
            $table->double('tax')->default(0.10);
            $table->string('service');
            $table->integer('wallets_id');
            $table->integer('bids_id')->nullable();
            $table->integer('statuses_id')->nullable();
            $table->integer('transaction_types_id');
            $table->foreign('wallets_id')->references('id')->on('wallets');
            $table->foreign('bids_id')->references('id')->on('bids');
            $table->foreign('statuses_id')->references('id')->on('statuses');
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

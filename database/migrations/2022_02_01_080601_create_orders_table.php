<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coin_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->enum('transaction', ['buy', 'sell']);
            $table->string('eth_address');
            $table->double('minimum_price', 10,4);
            $table->double('markup_price',10,2);
            $table->integer('exchange_transaction_fee');
            $table->integer('exchange_fix_price');
            $table->double('price', 10,4);
            $table->double('usePrice', 10,4);
            $table->double('sub_total', 10,4);
            $table->double('transaction_fee', 10,4);
            $table->double('service_charge', 10,4);
            $table->double('total', 10,4);
            $table->double('qty', 10,4);
            $table->string('notes')->nullable();
            $table->string('payment_proof')->nullable();
            $table->integer('status')->default(1);
            $table->string('txid')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

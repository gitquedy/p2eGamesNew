<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('coingecko_id');
            $table->string('icon');
            $table->double('minimum_price', 10,4);
            $table->double('markup_price',10,2);
            $table->boolean('isActive')->default(0);
            $table->boolean('isDefault')->default(0);
            $table->double('default', 10,2)->default(1);
            $table->double('step', 10,2)->default(0.1);
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
        Schema::dropIfExists('coins');
    }
}

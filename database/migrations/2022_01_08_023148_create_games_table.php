<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_description');
            $table->text('description');
            $table->string('image');
            $table->string('status');
            $table->string('device');
            $table->string('governance_token')->nullable();
            $table->string('rewards_token')->nullable();
            $table->double('minimum_investment', 20, 4)->nullable();
            $table->boolean('nft');
            $table->string('f2p');
            $table->string('screenshots')->nullable();
            $table->boolean('is_approved')->default(0);
            // $table->unsignedBigInteger('user_id');
            $table->string('genre_ids');
            $table->string('blockchain_ids');
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
        Schema::dropIfExists('games');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZTriedasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_triedas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cist',2)->nullable();
            $table->char('cisk',2)->nullable();
            $table->string('skname')->nullable();
            $table->string('enname')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('z_triedas');
    }
}

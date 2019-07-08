<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakturies', function (Blueprint $table) {
        $table->string('cislo')->unique();
        $table->string('dodavatel')->nullable();
        $table->string('predmet')->nullable();
        $table->string('sumasdph')->nullable();
        $table->string('datum')->nullable();
        $table->string('objednavka')->nullable(); 
        $table->string('mena')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturies');
    }
}

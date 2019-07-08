<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjednavkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('objednavkies', function (Blueprint $table) {
            $table->string('cislo')->unique();
            $table->string('dodavatel')->nullable();
            $table->string('predmet')->nullable();
            $table->string('sumasdph')->nullable();
            $table->string('datum')->nullable();
            $table->string('zmluva')->nullable();
            $table->string('schvalil')->nullable();
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
        Schema::dropIfExists('objednavkies');
    }
}

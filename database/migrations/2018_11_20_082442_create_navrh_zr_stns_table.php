<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavrhZrStnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otn_navrh_zr_stns', function (Blueprint $table) {
            $table->integer('kat_c')->unsigned()->unique();
            $table->string('ozn');
            $table->text('nazov');
            $table->date('date_vyd');
            $table->date('date_nav_zru');
            $table->string('zodp_zam');
            $table->boolean('public')->default(0);
            $table->integer('user_id')->unsigned(); 
            $table->timestamps(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otn_navrh_zr_stns');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('im_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kat_c');
            $table->string('skterm','200');
            $table->text('skdef')->nullable();
            $table->text('sknote')->nullable();
            $table->string('enterm','200')->nullable();
            $table->text('endef')->nullable();
            $table->text('ennote')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('old')->default(false)->nullable(); 
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('im_terms');
    }
}

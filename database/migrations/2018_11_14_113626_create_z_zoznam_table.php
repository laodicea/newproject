<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZZoznamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_zoznam', function (Blueprint $table) {
            $table->integer('kat_c')->unique();
            $table->integer('xcsn');
            $table->string('oznac','88')->nullable();
            $table->string('identif','50');
            $table->char('rokvyd',7)->nullable();
            $table->char('vestnik',5)->nullable();
            $table->char('triedzn',7)->nullable();
            $table->text('nahradene')->nullable();
            $table->text('nahradzujuce')->nullable();
            $table->string('ics')->nullable();
            $table->string('nariadvl')->nullable();
            $table->string('zmena')->nullable();
            $table->text('zmeny')->nullable();
            $table->text('zapracovane')->nullable();
            $table->date('datzr')->nullable();
            $table->text('nazdok');
            $table->text('citovane')->nullable();
            $table->char('cit_znak',1)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('z_zoznam');
    }
}

/*
            $table->char('cist',2);
            $table->char('cisk',2);
            $table->char('ciss',2);
            $table->string('ics');
            $table->date('date_vyd');
            $table->date('date_zru');
            $table->char('vestnik',7);
            $table->string('oznac');
            $table->string('namesk');
            $table->string('nahrad');
            $table->string('nahradzujuce');
            $table->string('nariadenie');
            $table->string('zmeny');
            $table->string('citovane'); 
            $table->string('zaprac');   */

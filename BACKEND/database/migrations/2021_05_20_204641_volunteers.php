<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Volunteers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->notNullable();
            $table->string('surname',200)->notNullable();
            $table->string('CI',15)->notNullable();
            $table->string('description',300)->nullable();
            $table->string('address',200)->notNullable();
            $table->string('availability',200)->nullable();
            $table->string('telefonNumber',30)->nullable();
            $table->string('image')->nullable();
            $table->string('state')->nullable();
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
        Schema::dropIfExists('volunteers');
    }
}

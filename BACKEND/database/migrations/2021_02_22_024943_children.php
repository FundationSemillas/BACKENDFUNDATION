<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Children extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('name',160)->notNullable();
            $table->string('surname',160)->notNullable();
            $table->timestamp('dateBirth')->notNullable();
            $table->String('age',20)->notNullable();
            $table->string('CI',15)->notNullable();
            $table->string('mothersName',200)->nullable();
            $table->string('fathersName',200)->nullable();
            $table->string('study')->notNullable();
            $table->string('houseAddress',200)->nullable();
            $table->string('schoolName',200)->nullable();
            $table->string('Image')->nullable();
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
        Schema::dropIfExists('children');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->notNullable();
            $table->string('description',300)->nullable();
            $table->string('place')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('hour')->nullable();
            $table->string('delay')->nullable();
           // $table->foreignId('blogs_id')->constrained('blogs');
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
        Schema::dropIfExists('events');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SponsorsEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->nullOnDelete();
            $table->foreignId('sponsor_id')->constrained('sponsors')->nullOnDelete();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('sponsorsEvents');
    }
}

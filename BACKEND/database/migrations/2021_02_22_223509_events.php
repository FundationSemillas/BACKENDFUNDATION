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
            $table->date('date')->nullable();
            $table->string('hour')->nullable();
            $table->string('delay')->nullable();
            $table->foreignId('blog_id')->constrained('blogs')->nullable()->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
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

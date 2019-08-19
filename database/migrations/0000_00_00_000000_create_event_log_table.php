<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event');
            $table->string('message')->nullable();
            $table->json('data')->nullable();
            $table->nullableMorphs('related');
            $table->timestamps();

            $table->index('event');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_log');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stadium_id');
            $table->date('match_date');
            $table->time('match_time');
            $table->string('match_type');
            $table->string('match_duration');
            $table->string('match_team');
            $table->string('match_team2');
            $table->unsignedDouble('price');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('payment_id');
            $table->string('payment_url');
            $table->string('status');
            $table->string('notes');
            $table->string('phone');
            $table->string('email');
            $table->softDeletes();
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
        Schema::dropIfExists('reservations');
    }
};

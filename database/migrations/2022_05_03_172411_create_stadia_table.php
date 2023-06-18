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
        Schema::create('stadia', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('firm_id');
            $table->text('description')->nullable();
            $table->time('opening_time');
            $table->time('closing_time');
            $table->time('daytime_start');
            $table->time('nighttime_start');
            $table->time('nighttime_end');
            $table->unsignedDouble('daytime_price');
            $table->unsignedDouble('nighttime_price');
            $table->boolean('recording')->default(0);
            $table->timestamps();
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('stadium_id')->references('id')->on('stadia')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('stadium_id');
        });
        Schema::dropIfExists('stadia');
    }
};

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
        Schema::create('firms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table){
            $table->foreign('firm_id')->references('id')->on('firms')->onDelete('cascade');
        });
        Schema::table('stadia', function (Blueprint $table){
            $table->foreign('firm_id')->references('id')->on('firms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (['stadia','users'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table){
                $table->dropConstrainedForeignId('firm_id');
            });
        }
        Schema::dropIfExists('firms');
    }
};

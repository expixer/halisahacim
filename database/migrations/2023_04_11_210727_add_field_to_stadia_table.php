<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stadia', function (Blueprint $table) {
            $table->string('address')->after('description');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('latitude')->after('state');
            $table->string('longitude')->after('latitude');
            $table->string('phone')->after('longitude');
            $table->string('email')->after('phone');
            $table->string('website')->after('email');
            $table->string('facebook')->after('website');
            $table->string('instagram')->after('facebook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stadia', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('website');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->after('firm_id');
            $table->foreignId('state_id')->nullable()->after('city_id');
            $table->enum('role', ['customer', 'field_owner'])->default('customer')->after('mobile_verify_code_sent_at');
            $table->boolean('is_admin')->default(false)->after('mobile_verify_code_sent_at');
            $table->boolean('is_active')->default(true)->after('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('city_id');
            $table->dropColumn('state_id');
            $table->dropColumn('is_admin');
            $table->dropColumn('is_active');
            $table->dropColumn('role');
        });
    }
};

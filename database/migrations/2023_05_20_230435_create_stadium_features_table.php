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
        Schema::create('stadium_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stadium_id')->constrained()->onDelete('cascade')->nullOnDelete();
            $table->string('name');
            $table->string('value');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_required')->comment('is it required for every stadium')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stadium_features');
    }
};

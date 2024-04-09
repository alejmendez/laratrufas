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
        Schema::create('harvest_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('harvest_id')->constrained();
            $table->foreignId('plant_id')->constrained();
            $table->integer('quality');
            $table->decimal('weight', total: 5, places: 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_details');
    }
};

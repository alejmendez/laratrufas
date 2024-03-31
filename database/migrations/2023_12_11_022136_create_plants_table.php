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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->date('planned_at');
            $table->string('nursery_origin', 80);
            $table->string('code', 12)->unique();
            $table->string('row', 2);
            $table->string('blueprint')->nullable();
            $table->foreignId('quarter_id')->constrained();
            $table->foreignId('plant_type_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};

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
        Schema::create('quarters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->decimal('area', total: 5, places: 2);

            $table->integer('responsible_id');
            $table->foreign('responsible_id')->references('id')->on('users');

            $table->string('blueprint')->nullable();

            $table->foreignId('field_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quarters');
    }
};

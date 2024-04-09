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
        Schema::create('harvests', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->string('batch', 2);

            $table->foreignId('dog_id')->constrained();
            $table->integer('farmer_id');
            $table->foreign('farmer_id')->references('id')->on('users');
            $table->integer('assistant_id');
            $table->foreign('assistant_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};

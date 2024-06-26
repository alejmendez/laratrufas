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
        Schema::create('harvest_quarter', function (Blueprint $table) {
            $table->id();

            $table->integer('harvest_id')->unsigned()->nullable();
            $table->foreign('harvest_id')->references('id')->on('harvests')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('quarter_id')->unsigned()->nullable();
            $table->foreign('quarter_id')->references('id')->on('quarters')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_quarter');
    }
};

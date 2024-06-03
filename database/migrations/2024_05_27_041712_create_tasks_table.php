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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->string('repeat_number');
            $table->string('repeat_type');
            $table->string('priority');
            $table->date('start_date');
            $table->date('end_date');

            $table->foreignId('field_id')->constrained();
            $table->foreignId('quarter_id')->constrained();
            $table->foreignId('plant_id')->constrained();

            $table->integer('responsible_id');
            $table->foreign('responsible_id')->references('id')->on('users');
            $table->text('note')->nullable();
            $table->text('comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

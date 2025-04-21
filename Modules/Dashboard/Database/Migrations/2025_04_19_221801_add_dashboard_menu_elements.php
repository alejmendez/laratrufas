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
        $dashboardModule = DB::table('modules')->where('slug', 'dashboard')->first();

        DB::table('menus')->insert([
            'text' => 'menu.dashboard',
            'link' => 'dashboard.index',
            'icon' => 'fa-solid fa-house',
            'order' => 0,
            'parent_id' => null,
            'module_id' => $dashboardModule->id,
            'active_with' => 'dashboard.*',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dashboardModule = DB::table('modules')->where('slug', 'dashboard')->first();
        DB::table('menus')->where('module_id', $dashboardModule->id)->delete();
    }
};

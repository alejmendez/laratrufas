<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $module = DB::table('modules')->where('slug', 'users')->first();

        $menu = [
            [
                'text' => 'menu.settings',
                'children' => [
                    [
                        'text' => 'menu.users',
                        'link' => 'users.index',
                        'icon' => 'fa-solid fa-users',
                        'active_with' => 'users.*',
                    ],
                ],
            ],
        ];

        $menuGroupOrder = 0;
        foreach ($menu as $item) {
            $menuElementOrder = 0;
            $menuGroup = DB::table('menus')->where('text', $item['text'])->first();
            if (! $menuGroup) {
                $menuGroupId = DB::table('menus')->insertGetId([
                    'text' => $item['text'],
                    'order' => $menuGroupOrder++,
                ]);
                $menuGroup = (object) ['id' => $menuGroupId];
            } else {
                DB::table('menus')->where('id', $menuGroup->id)->update([
                    'order' => $menuGroupOrder++,
                ]);
            }

            foreach ($item['children'] as $child) {
                $menuItem = DB::table('menus')->where('text', $child['text'])->first();
                if (! $menuItem) {
                    $menuItem = DB::table('menus')->insert([
                        'text' => $child['text'],
                        'link' => $child['link'],
                        'icon' => $child['icon'],
                        'active_with' => $child['active_with'],
                        'parent_id' => $menuGroup->id,
                        'order' => $menuElementOrder++,
                        'module_id' => $module->id,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $module = DB::table('modules')->where('slug', 'users')->first();
        DB::table('menus')->where('module_id', $module->id)->delete();
    }
};

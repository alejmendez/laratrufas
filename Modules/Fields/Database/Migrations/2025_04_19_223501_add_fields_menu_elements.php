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
        $module = DB::table('modules')->where('slug', 'fields')->first();

        $menu = [
            [
                'text' => 'menu.management',
                'children' => [
                    [
                        'text' => 'menu.fields',
                        'link' => 'fields.index',
                        'icon' => 'fa-solid fa-table-cells',
                        'active_with' => "fields.*",
                    ],
                    [
                        'text' => 'menu.quarters',
                        'link' => 'quarters.index',
                        'icon' => 'fa-solid fa-table-cells-large',
                        'active_with' => "quarters.*",
                    ],
                    [
                        'text' => 'menu.plants',
                        'link' => 'plants.index',
                        'icon' => 'fa-brands fa-envira',
                        'active_with' => "plants.*",
                    ],
                ],
            ],
            [
                'text' => 'menu.harvest_management',
                'children' => [
                    [
                        'text' => 'menu.harvest',
                        'link' => 'harvests.index',
                        'icon' => 'fa-solid fa-basket-shopping',
                        'active_with' => "harvests.*",
                    ],
                    [
                        'text' => 'menu.harvest_details',
                        'link' => 'harvests.details.create',
                        'icon' => 'fa-solid fa-barcode',
                        'active_with' => "harvests.details.*",
                    ],

                    [
                        'text' => 'menu.batch',
                        'link' => 'batches.index',
                        'icon' => 'fa-solid fa-table-list',
                        'active_with' => "batches.*",
                    ],

                    [
                        'text' => 'menu.liquidations',
                        'link' => 'liquidations.index',
                        'icon' => 'fa-solid fa-file-invoice-dollar',
                        'active_with' => "liquidations.*",
                    ],
                ]
            ],
            [
                'text' => 'menu.records',
                'children' => [
                    [
                        'text' => 'menu.machineries',
                        'link' => 'machineries.index',
                        'icon' => 'fa-solid fa-tractor',
                        'active_with' => "machineries.*",
                    ],
                    [
                        'text' => 'menu.tools',
                        'link' => 'tools.index',
                        'icon' => 'fa-solid fa-wrench',
                        'active_with' => "tools.*",
                    ],
                    [
                        'text' => 'menu.security_equipments',
                        'link' => 'security_equipments.index',
                        'icon' => 'fa-solid fa-shield-heart',
                        'active_with' => "security_equipments.*",
                    ],
                ]
            ],
            [
                'text' => 'menu.settings',
                'children' => [
                    [
                        'text' => 'menu.dogs',
                        'link' => 'dogs.index',
                        'icon' => 'fa-solid fa-dog',
                        'active_with' => "dogs.*",
                    ],
                    [
                        'text' => 'menu.bulk_uploads',
                        'link' => 'bulk.index',
                        'icon' => 'fa-solid fa-file-arrow-up',
                        'active_with' => "bulk.*",
                    ],
                ]
            ],
        ];

        $menuGroupOrder = 0;
        foreach ($menu as $item) {
            $menuElementOrder = 0;
            $menuGroup = DB::table('menus')->where('text', $item['text'])->first();
            if (!$menuGroup) {
                $menuGroupId = DB::table('menus')->insertGetId([
                    'text' => $item['text'],
                    'order' => $menuGroupOrder++,
                ]);
                $menuGroup = (object)['id' => $menuGroupId];
            } else {
                DB::table('menus')->where('id', $menuGroup->id)->update([
                    'order' => $menuGroupOrder++,
                ]);
            }

            foreach ($item['children'] as $child) {
                $menuItem = DB::table('menus')->where('text', $child['text'])->first();
                if (!$menuItem) {
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
        $module = DB::table('modules')->where('slug', 'fields')->first();
        DB::table('menus')->where('module_id', $module->id)->delete();
    }
};

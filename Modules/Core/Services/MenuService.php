<?php

namespace Modules\Core\Services;

use Illuminate\Support\Str;
use Modules\Users\Models\User;
use Modules\Core\Models\Module;
use Modules\Core\Models\Menu;
use Illuminate\Http\Request;

class MenuService
{
    protected static int $modulesTtl = 600;
    protected static int $menusTtl = 600;

    protected $user;
    protected $request;

    public function __construct(Request $request, User $user = null)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function getMenu()
    {
        if (!$this->user) {
            return null;
        }

        $modules = $this->getModules();
        $menus = $this->getMenus();
        $menuData = $this->getMenuData($modules, $menus);
        // dd($menus->toArray(), $menuData);

        return $menuData;
    }

    public function getMenuData($modules, $menus, $parentId = null, $menuElement = null)
    {
        if ($menuElement) {
            $children = $menus->where('parent_id', $parentId);
            if ($children->count() > 0) {
                $childrenData = $children->map(function ($child) use ($modules, $menus) {
                    return $this->getMenuData($modules, $menus, $child->id, $child);
                })->values();

                if ($childrenData->isEmpty()) {
                    return null;
                }

                return [
                    'text' => $menuElement->text,
                    'children' => $childrenData,
                ];
            } else {
                if (!isset($modules[$menuElement->module_id])) {
                    return null;
                }

                return [
                    'text' => $menuElement->text,
                    'link' => route($menuElement->link),
                    'icon' => $menuElement->icon,
                    'active' => $this->request->routeIs($menuElement->active_with),
                ];
            }

        }

        return $menus->where('parent_id', $parentId)->map(function ($menu) use ($modules, $menus) {
            return $this->getMenuData($modules, $menus, $menu->id, $menu);
        })->values();
    }

    protected function getModules()
    {
        return cache()->remember('modules', self::$modulesTtl, function () {
            return Module::where('is_active', true)->pluck('name', 'id');
        });
    }

    protected function getMenus()
    {
        return cache()->remember('menus', self::$menusTtl, function () {
            return Menu::orderBy('order')->get();
        });
    }
}

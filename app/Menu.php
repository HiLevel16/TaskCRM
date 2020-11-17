<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Menu extends Model
{
    /**
     *
     */
    public static function getMenu()
    {
        $menuRaw = static::proccessMenu(Config::get('menu'));
        $menu = [];
        foreach ($menuRaw as $menuRawItem) {
            foreach ($menuRawItem as $menuItem) {
                if (isset($menuItem['sub'])) {
                    foreach ($menuItem['sub'] as $key => $subMenuItem) {
                        foreach ($subMenuItem as $subItem) {
                            $menuItem['sub'][] = $subItem;
                        }
                        unset($menuItem['sub'][$key]);

                    }
                }
                $menu[] = $menuItem;
            }
        }
        return $menu;
    }

    /**
     * @param $menu
     */
    private static function proccessMenu($menu)
    {
        foreach ($menu as $permission => $menu_items)
        {
            if (strpos($permission, '|') !== false) {
                $permissionArr = explode('|', $permission);
            } else {    //Cast string to array string
                $permissionArr = [];
                $permissionArr[] = $permission;
            }
            $flag = false;
            foreach ($permissionArr as $perm) {
                if (Auth::user()->hasPermission($perm)) {
                    $flag = true;
                }
            }
            if (!$flag) {
                unset($menu[$permission]);
                continue;
            }
            foreach ($menu_items as $menu_item) {
                if (isset($menu_item['sub'])) {
                    $menu_item['sub'] = static::proccessMenu($menu_item['sub']);
                }
            }
        }
        return $menu;
    }
}

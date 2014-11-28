<?php

namespace Src\Modules\Main\Models;

use App\Core\Model;
use App\Core\Container;
use App\Core\Router;

class MenuModel extends Model
{

    public function setMenu($menuItem)
    {
        foreach ($menuItem as $itemName => $itemValues) {
            $menuItemExist = $this->select('menus', array('item_name' => $itemName));
            if (empty($menuItemExist)) {
                $this->insert('menus', array_merge($itemValues, array('item_name' => $itemName)));
            }
        }
    }

    public function getMenu($menuName)
    {
        $menuData = $this->select('menus',
            array('menu_name' => $menuName),
            array('parent_id', 'title', 'uri', 'weight', 'item_name')
        );

        $menu = array();
        foreach ($menuData as $menuItem) {
            $menuItem['uri'] = Router::buildUrl($menuItem['uri']);
            $menu[$menuItem['item_name']] = $menuItem;
            unset($menu[$menuItem['item_name']]['item_name']);
        }

        return $menu;
    }

    public function getMenuList()
    {
        $menuData = $this->select(
            'menus',
            array(),
            array('menu_name')
        );

        return $menuData;
    }

}

<?php

namespace Src\Modules\Main\Models;

use App\Core\Model;
use App\Core\Container;
use App\Core\Router;
use Src\Modules\Entity\Models\EntityModel;

class MenuModel extends EntityModel
{
    protected $table = 'menus';

    protected $fields = array(
        'menu_key',
        'title',
    );

    public function getFields()
    {
        return $this->fields;
    }

    public function setMenu($menuItem)
    {
        /*foreach ($menuItem as $itemName => $itemValues) {
            $menuItemExist = $this->select('menus', array('item_name' => $itemName));
            if (empty($menuItemExist)) {
                $this->insert('menus', array_merge($itemValues, array('item_name' => $itemName)));
            }
        }*/
    }

    public function getMenu($menuKey)
    {
        $menuData = $this->select(
            $this->table,
            array('menu_key' => $menuKey),
            array('id')
        );
        if (!empty($menuData)) {
            $menuItemsData = Container::get('Main/MenuItemModel')
                 ->selectEntity(
                     array('menu_id' => $menuData['0']['id']),
                     array('parent_id', 'title', 'url'),
                     array('columns' => 'weight', 'type' => 'ASC')
                 );

            foreach ($menuItemsData as $key => $row) {
                $menuItemsData[$key]['url'] = Router::buildUrl($row['url']);
            }

            return $menuItemsData;

        }
    }

}

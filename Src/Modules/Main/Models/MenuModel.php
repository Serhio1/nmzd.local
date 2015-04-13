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

    public function getMenu($menuKey)
    {
        
        $menusConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'menus.json');
        $menusConf = json_decode($menusConfJson, true);
        
        $menu = array();
        foreach ($menusConf['rows'] as $key => $row) {
            if (!empty($row['text_id']) && $row['text_id'] == $menuKey) {
                $menu = $row;
            }
        }
        
        return $menu;
        
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

<?php

namespace Src\Modules\Main\Models;

use App\Core\Model;
use App\Core\Container;
use App\Core\Router;
use Src\Modules\Entity\Models\EntityModel;

class MenuItemModel extends EntityModel
{
    protected $table = 'menu_items';

    protected $fields = array(
        'menu_id',
        'parent_id',
        'title',
        'url',
        'weight',
    );

    protected $parent = 'menu';

}

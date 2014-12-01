<?php

/**
 * Controller for Menu Entity
 */

namespace Src\Modules\Admin\Controllers;

use App\Core\Container;
use App\Core\Controller;
use App\Core\Router;
use \PFBC\Form;
use \PFBC\View;
use Src\Modules\Admin\Forms\ModulesListForm;
use Src\Modules\Admin\Models\AdminModel;
use Src\Modules\Entity\Controllers\EntityController;


class MenuItemController extends EntityController
{
    protected $entity = 'Main/MenuItemModel';

    protected $form = '\\Src\\Modules\\Admin\\Forms\\MenuItemForm';

    protected $entityUrl = '/admin/menu/item';

    protected $block = 'block3';

    /**
     * @throws \Exception
     */
    protected function preProcessView()
    {
        Container::get('params')->setThemeData('layout', '3-9');

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => array(
                        'admin_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                            'vars' => array(
                                'list' => Container::get('Main/MenuModel')->getMenu('admin_menu'),
                                'brand' => 'НМЗД',
                            )
                        )
                    )
                )
            )
        );
    }

}
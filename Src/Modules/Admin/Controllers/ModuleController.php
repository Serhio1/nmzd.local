<?php

namespace Src\Modules\Admin\Controllers;

use Src\Modules\Admin\Forms\ModuleListForm;
use Src\Modules\Entity\Controllers\EntityController;
use App\Core\Container;

class ModuleController extends EntityController
{
    protected $entity = 'Main/ModuleModel';

    protected $entityUrl = '/admin/model';

    protected $form = '\\Src\\Modules\\Admin\\Forms\\ModuleForm';

    protected $block = 'block3';

    public function viewAllAction($request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new ModuleListForm('update'), $formConf, $request, $this->block);

        return $this->render();
    }

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
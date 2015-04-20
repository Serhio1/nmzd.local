<?php

namespace Src\Modules\Pdf\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use App\Core\Container;

class PdfEntityController extends EntityController
{
    protected $entity = 'Pdf/PdfEntityModel';

    protected $entityUrl = '/pdf';

    protected $form = '\\Src\\Modules\\Pdf\\Forms\\PdfEntityForm';

    protected $block = 'block3';
    
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
                            )
                        )
                    ),

                )
            )

        );
    }
    
}


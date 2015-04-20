<?php

namespace Src\Modules\Pdf\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends EntityController
{
    protected $entity = 'Pdf/PdfTemplateModel';

    protected $entityUrl = '/pdf/template';

    protected $form = '\\Src\\Modules\\Pdf\\Forms\\PdfTemplateForm';

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


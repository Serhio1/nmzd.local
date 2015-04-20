<?php

namespace Src\Modules\Pdf\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;

class ConfigController extends EntityController
{
    protected $entity = 'Pdf/PdfConfigModel';

    protected $entityUrl = '/pdf/config';

    protected $form = '\\Src\\Modules\\Pdf\\Forms\\PdfConfigForm';

    protected $block = 'block3';
    
    
    public $filename = 'test';
    
    public $styles = array(
        'Src/Modules/Pdf/Views/css/pdfstyle.css'
    );
    
    public function testAction()
    {
        $pdfVars = array('test'=>'світ');
        return Container::get('Pdf/PdfEntityModel')->outPdf('test', $pdfVars);
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
                            )
                        )
                    ),

                )
            )

        );
    }

}

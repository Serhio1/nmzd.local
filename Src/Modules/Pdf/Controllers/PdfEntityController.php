<?php

namespace Src\Modules\Pdf\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PdfEntityController extends EntityController
{
    protected $entity = 'Pdf/PdfEntityModel';

    protected $entityUrl = '/pdf';

    protected $form = '\\Src\\Modules\\Pdf\\Forms\\PdfEntityForm';

    protected $block = 'block3';
    
    public function downloadPdfAction(Request $request)
    {
        if ($request->query->has('entity') &&
            $request->query->has('option') &&
            $request->query->has('pdf')) {
            
            if (Container::registered($request->query->get('entity'))) {
                $entity = Container::get($request->query->get('entity'));
            }
            $pdfVarsMethod = 'Pdf' . ucfirst($request->query->get('option'));
            $pdf = $request->query->get('pdf');
            $pdfVars = $entity->$pdfVarsMethod($request);

            return Container::get('Pdf/PdfEntityModel')->outPdf($pdf, $pdfVars);
        } else {
            return new Response('Error');
        }
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


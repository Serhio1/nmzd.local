<?php

namespace Src\Modules\Nmkd\Controllers;

use App\Core\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;

class NmkdController extends Controller
{
    protected $entity = 'Nmkd/DisciplineModel';

    protected $entityUrl = '/nmkd/discipline/menu';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\NmkdForm';

    protected $block = 'block3';

    public function createAction(Request $request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new $this->form('create'), $formConf, $request, $this->block);
        
        return $this->render();
    }
    
    public function editAction(Request $request)
    {
        $formConf = array('action' => '/nmkd/nmkd/edit');
        $form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);

        if ($request->isXmlHttpRequest()) {
            //$formConf = array('action' => '/nmkd/nmkd/edit');
            //$form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);
            $twig = Container::get('twig');
            //$response = $twig->render($form['view'], $form['vars']);  
            return new Response($form['vars']['form']);
            //return new Response($response);
        }
        
        return $this->render();
    }
    
    public function pdfAction(Request $request)
    {
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => array(
                        'admin_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                            'vars' => array(
                                'list' => Container::get('Main/MenuModel')->getMenu('nmkd_pdf_menu', array('id'=>$request->query->get('id'))),
                            )
                        )
                    ),

                )
            )
        );
        return $this->render();
    }

}


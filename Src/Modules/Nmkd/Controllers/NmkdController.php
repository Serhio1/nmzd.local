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
        if ($request->isXmlHttpRequest()) {
            if ($request->request->get('key') == 'autosave') {
                return new Response('Збережено.');
            }
            //$formConf = array('action' => '/nmkd/nmkd/edit');
            //$form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);
            $twig = Container::get('twig');
            //$response = $twig->render($form['view'], $form['vars']);  
            return new Response($form['vars']['form']);
            //return new Response($response);
        }
        
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
            'aje' => '/Src/Views/Themes/Bootstrap/js/aje.js',
        );
        

        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        
        return $this->render();
    }
    
    public function editAction(Request $request)
    {
        
        $formConf = array('action' => $this->entityUrl, 'prevent' => array('bootstrap', 'jQuery'));
        $form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);

        if ($request->isXmlHttpRequest()) {
            if ($request->request->get('ajaxData')['key'] == 'autosave') {
                return new Response('Збережено.');
            }
            //$formConf = array('action' => '/nmkd/nmkd/edit');
            //$form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);
            $twig = Container::get('twig');
            //$response = $twig->render($form['view'], $form['vars']);  
            return new Response($form['vars']['form']);
            //return new Response($response);
        }
        
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
            'aje' => '/Src/Views/Themes/Bootstrap/js/aje.js',
            'jquery_ui' => '/vendor/pfbc/pfbc/PFBC/Resources/jquery-ui/js/jquery-ui.min.js'
        );
        

        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        
        
        
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
    
    public function pdfTestAction(Request $request)
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


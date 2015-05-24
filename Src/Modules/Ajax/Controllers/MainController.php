<?php

/**
 * Main controller for Ajax module
 */

namespace Src\Modules\Ajax\Controllers;

use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Controller;
use App\Core\Router;

class MainController extends Controller
{
    
    protected $entityUrl = '/nmkd/discipline/menu';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\NmkdForm';

    protected $block = 'block3';

    public function indexAction($request)
    {
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
            'aje' => '/Src/Views/Themes/Bootstrap/js/aje.js',
        );
        
        $jsBottom = array(
            'autosave' => '/Src/Modules/Nmkd/Forms/js/autosave.js',
        );
        
        
        $data = array();
        $data['script'] = new Response("$(`.ajecontainer`).aje().setData({`msg`:`ololo`,`block`:`block2`,`component`:`aje_test`}).setMenu(`.testMenu`);");
        
        $collectedComponent = array(
            'top_menu' => array(
                'view' => '/Src/Views/Themes/Bootstrap/Components/horizontal_pills.html.twig',
                'vars' => array(
                    'list' => array(
                        'children' => array(
                            array(
                                'title' => 'Створити',
                                'url' => Router::buildUrl('/discipline/create'),
                            )
                        ),
                    ),
                ),
            ),
            
            'aje_test' => array(
                'view' => '/Src/Views/Themes/Bootstrap/Components/ajax.html.twig',
                'vars' => array(
                    'url' => Router::buildUrl('/ajax/test'),
                    'script' => $data['script'],
                )
            ),
        );
        
        $formConf = array('action' => $this->entityUrl, 'prevent' => array('bootstrap', 'jQuery'));
        $form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);

        if ($request->isXmlHttpRequest()) {
            //$formConf = array('action' => '/nmkd/nmkd/edit');
            //$form = $this->useForm(new $this->form('update'), $formConf, $request, $this->block);
            $twig = Container::get('twig');
            //$response = $twig->render($form['view'], $form['vars']);  
            //return new Response($form['vars']['form']);
            //return new Response($response);
        }
        
        
        //$collectedComponent['rules']['ajemenu'] = array('topMenu'=>'aje_test');
        
        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        Container::get('params')->setThemeData(array('jsBottom' => $jsBottom));
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => $collectedComponent
                ),
            )
        );
        
        return $this->render($data);
    }
    
    public function testAction()
    {
        return new Response('test');
    }
    
}
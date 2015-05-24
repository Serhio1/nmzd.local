<?php

namespace Src\Modules\Main\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Controller;
use App\Core\Container;
use App\Core\Router;
use Src\Modules\Devel\Forms\GenModuleForm;

class MainController extends Controller
{
    public function indexAction(Request $request)
    {
        $onPage = $request->request->has('on_page') ? $request->request->get('on_page') : 1;
        $page = $request->request->has('page') ? $request->request->get('page') : 1;
        
        $countOfPages = round(Container::get('Nmkd/DisciplineModel')->getEntityCount() / $onPage);
        
        $disciplines = Container::get('Nmkd/DisciplineModel')->selectEntity(
                array(), 
                array('id','title'), 
                $order = array('columns' => 'title', 'type' => 'ASC'), 
                $paginate = array(($page-1)*$onPage, $onPage)
        );
        foreach ($disciplines as $key => $value) {
            
            $disciplines[$key]['url'] = Router::buildUrl('nmkd/discipline/menu', array('id' => $disciplines[$key]['id']));
            $disciplines[$key]['parent_id'] = -1;
        }


        Container::get('params')->setThemeData('layout', '12');
        Container::get('params')->setThemeData(array(
            'items' => array(
                'block2' => array(
                    'main_title' => array(
                        'view' => '/Src/Modules/Main/Views/Components/main_title.html.twig',
                        'vars' => array(
                            'title' => 'Вітаємо в АІАС НМЗД!',
                            'sub_title' => 'Для початку роботи оберіть дисципліну',
                        )
                    )
                ),
                'block3' => array(
                    'nmkd_menu' => array(
                        'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                        'vars' => array(
                            'list' => array('children' => $disciplines),
                            'brand' => 'НМЗД',
                        )
                    )
                )
            )
        ));
        
        $this->paginate($request, $countOfPages, array('items','block3','nmkd_menu'), array(1,2,3));
        
        return $this->render();
    }
    
    public function paginate($request, $countOfPages, $block, $count = array(10,50,100), $view = '')
    {
        $onPage = $request->request->has('on_page') ? $request->request->get('on_page') : 1;
        $page = $request->request->has('page') ? $request->request->get('page') : 1;
        
        $vars = Container::get('params')->getThemeData($block);
        $baseView = $vars['view'];
        if (empty($view)) {
            $vars['view'] = '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills_paged.html.twig';
        } else {
            $vars['view'] = $view;
        }
                
        Container::get('params')->setThemeData(array(
            'items' => array(
                'block3' => array(
                    'nmkd_menu' => array(
                        'view' => $vars['view'],
                        'vars' => array(
                            'list_tpl' => $baseView,
                            'count_on_page' => $count,
                            'on_page' => $onPage,
                            'page' => $page,
                            'count_of_pages' => $countOfPages
                        )
                    )
                )
            )
        ));
    }
    
    public function securityAction(Request $request)
    {
        $formConf = array('action' => $request->server->get('REQUEST_URI'));
        $this->useForm(new \Src\Modules\Main\Forms\SecurityForm('check_password'), $formConf, $request, 'block3');

        
        return $this->render();
    }

}

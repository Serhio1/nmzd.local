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
        Container::get('dispatcher')
            ->dispatch('Src/Modules/Admin/Controllers/MainController:indexAction');
        
        $disciplines = Container::get('Nmkd/DisciplineModel')->selectEntity(array(), array('id','title'));
        foreach ($disciplines as $key => $value) {
            $disciplines[$key]['url'] = Router::buildUrl('nmkd/discipline/menu', array('id' => $disciplines[$key]['id']));
            $disciplines[$key]['parent_id'] = -1;
        }


        Container::get('params')->setThemeData('layout', '12');
        Container::get('params')->setThemeData(
            array(
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
                                'list' => $disciplines,
                                'brand' => 'НМЗД',
                            )
                        )
                    )
                )
            )
        );
        
        return $this->render();
    }
    
    public function securityAction(Request $request)
    {
        $formConf = array('action' => $request->server->get('REQUEST_URI'));
        $this->useForm(new \Src\Modules\Main\Forms\SecurityForm('check_password'), $formConf, $request, 'block3');

        
        return $this->render();
    }

}

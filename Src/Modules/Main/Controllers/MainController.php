<?php

namespace Src\Modules\Main\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Controller;
use App\Core\Container;

use Src\Modules\Devel\Forms\GenModuleForm;

class MainController extends Controller
{
    public function indexAction(Request $request)
    {
        Container::get('dispatcher')
            ->dispatch('Src/Modules/Admin/Controllers/MainController:indexAction');


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
                                'list' => Container::get('params')->getMenu('discipline_menu'),
                                'brand' => 'НМЗД',
                            )
                        )
                    )
                )
            )
        );

        return $this->render();
    }
}

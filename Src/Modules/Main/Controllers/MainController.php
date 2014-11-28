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
        $gen_form = new GenModuleForm();


        //$themeSettings = Container::get('theme_settings');

        /*$themeSettings['items']['block2']['/Src/Modules/Main/Views/Templates/home.html.twig'] = array();
        $themeSettings['items']['block3']['/Src/Modules/Devel/Views/Templates/gen_module.html.twig'] = array();
*/
        //dump($themeSettings);

        //dump(Container::get('params')->getThemeData());

        Container::get('params')->setThemeData('layout', '12');
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block3' => array(
                        'nmkd_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                            'vars' => array(
                                'list' => Container::get('params')->getMenu('nmkd_menu'),
                                'brand' => 'НМЗД',
                            )
                        )
                    )
                )
            )
        );

        return $this->renderTwig(
            '/Src/Views/layout.html.twig',
            array('gen_form' => $gen_form->build(array(
                'action' => '/devel/gen-module',
                'view' => 'vertical',
                "labelToPlaceholder" => 1,
            ))->render(true)));
    }
}

<?php

namespace Src\Modules\Nmkd\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;

class DisciplineController extends EntityController
{

    protected $entity = 'Nmkd/DisciplineModel';

    protected $entityUrl = '/nmkd/discipline';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\DisciplineForm';

    protected $block = 'block3';
    
    public function menuAction(Request $request)
    {
        Container::get('params')->setThemeData('layout', '12');
        $disciplineMenu = Container::get('Main/MenuModel')->getMenu('discipline_menu', array('id'=>$request->query->get('id')));
        /*foreach ($disciplineMenu['children'] as $key => $value) {
            $disciplineMenu['children'][$key]['url'] .= '?id=' . $request->query->get('id');
        }*/
        
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
            /*'AjE' => '/Src/Views/Themes/Bootstrap/js/ajaxEngine.js',
            'AjEMenu' => '/Src/Views/Themes/Bootstrap/js/AjEMenu.js',*/
        );
        $jsBottom = array(
            //'ajaxDisciplineMenu' => '/Src/Modules/Nmkd/Views/js/ajaxDisciplineMenu.js',
        );
        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        Container::get('params')->setThemeData(array('jsBottom' => $jsBottom));
                
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => array(
                        'nmkd_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                            'vars' => array(
                                'list' => $disciplineMenu,
                                'id' => 'discipline-menu',
                            )
                        ),
                    )
                ),
            )
        );
        
        return $this->render();
    }

}
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
        //TODO: add possibility to send context.
        $disciplineMenu = Container::get('Main/MenuModel')->getMenu('discipline_menu');
        foreach ($disciplineMenu as $key => $value) {
            $disciplineMenu[$key]['url'] .= '?id=' . $request->query->get('id');
        }
                
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => array(
                        'main_title' => array(
                            'view' => '/Src/Modules/Main/Views/Components/main_title.html.twig',
                            'vars' => array(
                                'title' => 'Оберіть дію',
                            )
                        )
                    ),
                    'block3' => array(
                        'nmkd_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                            'vars' => array(
                                'list' => $disciplineMenu,
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
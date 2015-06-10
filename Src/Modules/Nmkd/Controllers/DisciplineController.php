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
        $disciplineMenu = Container::get('Main/MenuModel')
                ->getMenu('discipline_menu', array('id'=>$request->query->get('id')));
                
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
    
    public function viewAllAction($request)
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
        
        return parent::viewAllAction($request);
    }
    
    public function viewAction($request)
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
        
        return parent::viewAction($request);
    }
    
    public function createAction($request)
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
        
        return parent::createAction($request);
    }
    
    public function editAction($request)
    {
        Container::get('params')->setThemeData('layout', '3-9');
        
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
            'AjE' => '/Src/Views/Themes/Bootstrap/js/aje.js',
        );
        $jsBottom = array(
            'autosave' => '/Src/Modules/Nmkd/Forms/Js/autosave.js'
        );
        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        Container::get('params')->setThemeData(array('jsBottom' => $jsBottom));
                

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
        
        return parent::editAction($request);
    }
    
    public function deleteAction($request)
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
        
        return parent::deleteAction($request);
    }
    


}
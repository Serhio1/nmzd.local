<?php

namespace Src\Modules\Nmkd\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use App\Core\Router;
use Symfony\Component\HttpFoundation\Response;

class LabController extends EntityController
{

    protected $entity = 'Nmkd/LabModel';

    protected $entityUrl = '/nmkd/lab';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\LabForm';

    protected $block = 'block3';
    
    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function viewAllAction($request)
    {
        $parent = Container::get($this->entity)->getParent();
        if (empty($parent)) {
            $menuList = Container::get($this->entity)->getEntityList();
        } else {
            $menuList = Container::get($this->entity)->getParentEntityList($request->query->get('id'));
        }

        $list = array();
        $titles = array(
            'Список',
            'Опції',
        );
        foreach ($menuList as $row) {
            $list[$row['title']] = array(
                'Редагувати' => Router::buildUrl($this->entityUrl . '/edit', array('id' => $row['id'])),
                'Видалити' => Router::buildUrl($this->entityUrl . '/delete', array('id' => $row['id'])),
            );
        }
        
        /*$topMenuComponent = '/Src/Views/Themes/Bootstrap/Components/horizontal_pills.html.twig';
        $topMenuVars = array(
                    'list' => array(
                        'children' => array(
                            array(
                                'title' => 'Створити',
                                'url' => (empty($parent)) ?
                                    Router::buildUrl($this->entityUrl . '/create') :
                                    Router::buildUrl($this->entityUrl . '/create', array('id' => $request->query->get('id'))),
                            )
                        ),
                    ),
                );
        $disciplinesListComponent = '/Src/Views/Themes/Bootstrap/Components/list_with_options.html.twig';
        $disciplinesListVars = array(
                    'list' => $list,
                    'titles' => $titles,
                );
        
        

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    $this->block => array(
                        'menus_top_menu' => array(
                            'view' => $topMenuComponent,
                            'vars' => $topMenuVars,
                        ),
                        'menus_list' => array(
                            'view' => $disciplinesListComponent,
                            'vars' => $disciplinesListVars,
                        ),
                    )
                )
            )
        );*/
        $view = '/Src/Views/Themes/Bootstrap/Components/entity_list.html.twig';
        $viewVars = array('entity' => array(
                            'isAjax' => ($request->isXmlHttpRequest()) ? true : false,
                            'topMenu' => array(
                                'children' => array(
                                    array(
                                        'title' => 'Створити',
                                        'url' => (empty($parent)) ?
                                            Router::buildUrl($this->entityUrl . '/create') :
                                            Router::buildUrl($this->entityUrl . '/create', array('id' => $request->query->get('id'))),
                                    )
                                ),
                            ),
                            'table' => array(
                                'list' => $list,
                                'titles' => $titles,
                            )
                        ),
                    );
        
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    $this->block => array(
                        'entity_list' => array(
                            'view' => $view,
                            'vars' => $viewVars,
                        ),
                    )
                )
            )
        );
        
        if ($request->isXmlHttpRequest()) {
            $twig = Container::get('twig');
            $response = '';
            $response .= $twig->render($view, $viewVars);
            //$response .= $twig->render($disciplinesListComponent, $disciplinesListVars);
        
            return new Response($response);
        }
        

        return $this->render();
    }

}
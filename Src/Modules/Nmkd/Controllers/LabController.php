<?php

namespace Src\Modules\Nmkd\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use App\Core\Router;

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

        $parent = Container::get($this->entity)->getParent();

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    $this->block => array(
                        'menus_top_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/horizontal_pills.html.twig',
                            'vars' => array(
                                'list' => array(
                                    'children' => array(
                                        array(
                                            'title' => 'Створити',
                                            'url' => (empty($parent)) ?
                                                Router::buildUrl($this->entityUrl . '/create') :
                                                Router::buildUrl($this->entityUrl . '/create', array('id' => $request->query->get('id'))),
                                        )
                                    ),
                                )
                            ),
                        ),
                        'menus_list' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/list_with_options.html.twig',
                            'vars' => array(
                                'list' => $list,
                                'titles' => $titles,
                            ),
                        ),
                    )
                )
            )
        );

        return $this->render();
    }

}
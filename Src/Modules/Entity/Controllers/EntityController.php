<?php

/**
 * Controller for Menu Entity
 */

namespace Src\Modules\Entity\Controllers;

use App\Core\Container;
use App\Core\Controller;
use App\Core\Router;
use \PFBC\Form;
use \PFBC\View;
use Src\Modules\Admin\Forms\ModulesListForm;
use Src\Modules\Admin\Models\AdminModel;


class EntityController extends Controller
{

    /**
     * Callback for /admin/menus uri.
     *
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
            'Список Меню',
            'Опції',
        );
        foreach ($menuList as $row) {
            $list[$row['title']] = array(
                'Переглянути' => Router::buildUrl($this->entityUrl . '/view', array('id' => $row['id'])),
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
                                    'top_entity_menu' => array(
                                        'title' => 'Створити',
                                        'url' => (empty($parent)) ?
                                            Router::buildUrl($this->entityUrl . '/create') :
                                            Router::buildUrl($this->entityUrl . '/create', array('id' => $request->query->get('id'))),
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

    /**
     * Callback for /admin/menu/view uri.
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($request)
    {
        $id = $request->query->get('id');

        $menuItemsList = Container::get($this->entity)
            ->selectEntity(array('id' => $id));

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    $this->block => array(
                        'menu_view' => array(
                            'view' => '/Src/Modules/Entity/Views/Components/std_entity_view.html.twig',
                            'vars' => array(
                                'fields' => $menuItemsList['0'],
                            ),
                        ),
                    )
                )
            )
        );

        return $this->render();
    }

    /**
     * Callback for /admin/menu/create uri.
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction($request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new $this->form('create'), $formConf, $request, $this->block);

        return $this->render();
    }

    /**
     * Callback for /admin/menu/edit uri.
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new $this->form('update'), $formConf, $request, $this->block);

        return $this->render();
    }

    /**
     * Callback for /admin/menu/delete uri.
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new $this->form('delete'), $formConf, $request, $this->block);

        return $this->render();
    }

}
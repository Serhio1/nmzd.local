<?php

namespace Src\Modules\Admin\Forms;

use App\Core\BaseForm;
use App\Core\IForm;
use App\Core\Router;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Symfony\Component\HttpFoundation\Request;
use Src\Modules\Admin\Models\AdminModel;
use App\Core\Container;

class DeleteEntityForm extends BaseForm
{
    protected $formName = 'menu_item_form';

    protected $steps = array(
        'deleteFormProcess',
    );

    protected $entity;




    protected function deleteFormProcess($form, $request, $config)
    {
        $id = $request->query->get('id');
        $values = Container::get('Main/MenuModel')->selectById($id);

        $config = array_merge($config, array("prevent" => array("bootstrap", "jQuery")));
        if (!empty($config['view'])) {
            $view = '\\PFBC\\View\\' . ucfirst($config['view']);
            $config['view'] = new $view;
        }
        $form->configure($config);

        $form->addElement(new Element\HTML('<legend>Створення нового меню</legend>'));
        $form->addElement(new Element\Hidden('form', $this->formName));

        $form->addElement(new Element\Textbox('Назва:', 'title', array(
            'required' => 1,
            'value' => empty($values['title']) ? '' : $values['title'],
        )));
        $form->addElement(new Element\Textbox('Ідентифікатор:', 'menu_key', array(
            'required' => 1,
            'value' => empty($values['menu_key']) ? '' : $values['menu_key'],
        )));

        $form->addElement(new Element\Button('Відмінити', 'button', array(
            'onclick' => 'history.go(-1);'
        )));
        $form->addElement(new Element\Button('Зберегти'));

        return $form;
    }

    public function submit(Request $request)
    {
        $menuTitle = $request->request->get('title');
        $menuKey = $request->request->get('menu_key');
        $model = Container::get('Main/MenuModel');
        if ($this->operation == 'create') {
            $model->createMenu(array(
                'title' => $menuTitle,
                'menu_key' => $menuKey,
            ), 'menu_key');
        }
        if ($this->operation == 'update') {
            $id = $request->query->get('id');
            $model->updateMenu(array(
                'title' => $menuTitle,
                'menu_key' => $menuKey,
            ), array('id' => $id));
        }
        $step = $request->request->get('step');
        if ($step == 'finish') {
            Container::get('router')->redirect($_SESSION[$this->formName]['action']);
        }

    }

}
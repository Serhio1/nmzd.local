<?php

namespace Src\Modules\Admin\Forms;

use App\Core\IForm;
use App\Core\Router;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;

class MenuItemForm extends EntityForm
{
    protected $formName = 'menu_item_form';

    protected $entity = 'Main/MenuItemModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити пункт меню? Цю дію неможливо відмінити.</legend>'));
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Видалити'));
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нового пункту меню</legend>'));


            $form->addElement(new Element\Textbox('Назва:', 'title', array(
                'required' => 1,
                'value' => empty($values['title']) ? '' : $values['title'],
            )));

            $form->addElement(new Element\Textbox('Uri:', 'url', array(
                'required' => 1,
                'value' => empty($values['url']) ? '' : $values['url'],
            )));

            $form->addElement(new Element\Number('Батьківський пункт:', 'parent_id',
                array(
                    'value' => empty($values['parent_id']) ? '-1' : $values['parent_id'],
                    'min' => '-1',
                )
            ));

            $form->addElement(new Element\Number('Вага:', 'weight', array(
                'required' => 1,
                'value' => empty($values['weight']) ? '1' : $values['weight'],
            )));

            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Зберегти'));
        }

        return $form;
    }

    protected function finishEvent($vars)
    {
        Container::get('router')->redirect('/admin/menu/view', array('id' => $vars['parent_id']));
    }

}

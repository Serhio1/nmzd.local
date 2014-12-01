<?php

namespace Src\Modules\Admin\Forms;

use App\Core\Router;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;

class ModuleForm extends EntityForm
{
    protected $formName = 'module_form';

    protected $entity = 'Main/ModuleModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {
        $request = Request::createFromGlobals();

        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити меню?</legend>'));
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Видалити'));
        } else {
            $form->addElement(new Element\Hidden('id', $request->query->get('id')));
            $form->addElement(new Element\HTML('<legend>Створення нового меню</legend>'));

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
        }

        return $form;
    }

}

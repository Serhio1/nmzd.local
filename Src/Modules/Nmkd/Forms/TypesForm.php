<?php

namespace Src\Modules\Nmkd\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use Src\Modules\Nmkd\Forms\Elements\LabCKEditor\LabCKEditor;
use App\Core\Container;

class TypesForm extends EntityForm
{

    protected $formName = 'types_form';

    protected $entity = 'Nmkd/TypesModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити дисципліну?</legend>'));
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Видалити'));
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нової дисципліни</legend>'));
            $form->addElement(new Element\Textbox('Назва:', 'title', array(
                'required' => 1,
                'value' => empty($values['title']) ? '' : $values['title'],
            )));
            $form->addElement(new Element\Textbox('Ключ:', 'key', array(
                'required' => 1,
                'value' => empty($values['key']) ? '' : $values['key'],
            )));
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Зберегти'));
        }

        return $form;
    }

}
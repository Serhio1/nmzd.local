<?php

namespace Src\Modules\Nmkd\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use PFBC\Element;

class LabForm extends EntityForm
{

    protected $formName = 'lab_form';

    protected $entity = 'Nmkd/LabModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити лабораторну?</legend>'));
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Hidden($request->cookies->get('disc_id'), 'discipline_id'));
            $form->addElement(new Element\Button('Видалити'));
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нової лабораторної</legend>'));


            $form->addElement(new Element\Textbox('Назва:', 'title', array(
                'required' => 1,
                'value' => empty($values['title']) ? '' : $values['title'],
            )));

            $form->addElement(new Element\CKEditor('Текст лабораторної:', 'body'));

            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Зберегти'));
        }

        return $form;
    }

}
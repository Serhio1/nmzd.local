<?php

namespace Src\Modules\Nmkd\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use PFBC\Element;

class DisciplineForm extends EntityForm
{

    protected $formName = 'discipline_form';

    protected $entity = 'Nmkd/DisciplineModel';

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

            $form->addElement(new Element\Number('Семестр:', 'semester', array(
                'required' => 1,
                'value' => empty($values['semester']) ? '' : $values['semester'],
            )));

            $form->addElement(new Element\Textbox('Id напряму:', 'id_speciality',
                array(
                    'value' => empty($values['id_speciality']) ? '' : $values['id_speciality'],
                    'min' => '-1',
                )
            ));

            $form->addElement(new Element\Textbox('Id спеціальності:', 'id_subspeciality', array(
                'required' => 1,
                'value' => empty($values['id_subspeciality']) ? '' : $values['id_subspeciality'],
            )));

            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Зберегти'));
        }

        return $form;
    }

}
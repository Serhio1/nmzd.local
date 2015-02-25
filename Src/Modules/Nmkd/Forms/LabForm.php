<?php

namespace Src\Modules\Nmkd\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
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
        $request = Request::createFromGlobals();
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити лабораторну?</legend>'));
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            //$request->cookies->get('discipline_id')
            //$form->addElement(new Element\Hidden('id', $request->query->get('id')));
            $form->addElement(new Element\Button('Видалити'));
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нової лабораторної</legend>'));
            
            $form->addElement(new Element\Hidden('discipline_id', $request->query->get('discipline_id')));

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
    
    
    public function submit(Request $request)
    {
        $vars = array();
        $entity = $this->getEntity();
        $fields = $entity->getFields();
        $params = array();
        $id = $request->query->get('id');
        foreach ($fields as $field) {
            $params[$field] = $request->request->get($field);
        }
        dump($request->request);
        echo '<hr>';
        dump($params); die();
        if ($this->operation == 'create') {
            $vars['parent_id'] = $id;
        } else {
            $parent = Container::get($this->entity)->getParent();
            if (!empty($parent)) {
                $parentId = Container::get($this->entity)->getParentId($id);
                $vars['parent_id'] = $parentId['0'][$parent . '_id'];
            }
        }
        if ($this->operation == 'create') {
            $id = $entity->createEntity($params);
            $vars['id'] = $id['0']['id'];
        }
        if ($this->operation == 'update') {
            $entity->updateEntity($params, array('id' => $id));
        }
        if ($this->operation == 'delete') {
            $entity->deleteEntity(array('id' => $id));
        }

        $step = $request->request->get('step');
        if ($step == 'finish') {
            $this->finishEvent($vars);
        }
        //echo 'trololo'; die('trololo');

    }

}
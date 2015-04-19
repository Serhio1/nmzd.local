<?php

namespace Src\Modules\Pdf\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use App\Core\Container;

class PdfTemplateForm extends EntityForm
{

    protected $formName = 'pdf_template_form';

    protected $entity = 'Pdf/PdfTemplateModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {     
        $request = Request::createFromGlobals();
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити шаблон?</legend>'));
            $this->addControls($form, $request);
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нового шаблону</legend>'));
            $form->addElement(new Element\Textbox('Назва:', 'title', array(
                'required' => 1,
                'value' => empty($values['title']) ? '' : $values['title'],
            )));
            
            $form->addElement(new Element\Textarea('Шаблон Twig', 'body', array(
                'value' => empty($values['body']) ? '' : $values['body'],
            )));
            
            $this->addControls($form, $request);
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
        if ($this->operation == 'create') {
            $parent = Container::get($this->entity)->getParent();
            if (!empty($parent)) {
                $vars['parent_id'] = $request->query->get('id');
            }
        } else {
            $parent = Container::get($this->entity)->getParent();
            if (!empty($parent)) {
                $parentId = Container::get($this->entity)->getParentId($id);
                $vars['parent_id'] = $parentId[0][$parent . '_id'];
            }
        }
        if ($this->operation == 'create') {
            $id = $entity->createEntity($params);
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

    }
    
    protected function finishEvent($vars = array())
    {
        if (!empty($vars['parent_id'])) {
            Container::get('router')->redirect(explode('?', $_SESSION[$this->formName]['action'])[0] . '?id=' . $vars['parent_id']);
        }
        Container::get('router')->redirect($_SESSION[$this->formName]['action']);
    }

}


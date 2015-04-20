<?php

namespace Src\Modules\Pdf\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use App\Core\Container;

class PdfEntityForm extends EntityForm
{

    protected $formName = 'pdf_entity_form';

    protected $entity = 'Pdf/PdfEntityModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {     
        $request = Request::createFromGlobals();
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити PDF?</legend>'));
            $this->addControls($form, $request);
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нового PDF</legend>'));
            $form->addElement(new Element\Textbox('Назва:', 'title', array(
                'required' => 1,
                'value' => empty($values['title']) ? '' : $values['title'],
            )));
            $form->addElement(new Element\Textbox('Індивідуальний ключ:', 'key', array(
                'required' => 1,
                'value' => empty($values['key']) ? '' : $values['key'],
            )));
            $templates = Container::get('Pdf/PdfTemplateModel')->selectEntity(array(), array('id','title'));
            $tplOptions = array();
            foreach ($templates as $row => $data) {
                $tplOptions[$data['id']] = $data['title'];
            }
            $tplDefault = array();
            if (isset($values['template_id'])) {
                $tplDefault[$values['template_id']] = $tplOptions[$values['template_id']];
            }
            $form->addElement(new Element\Select('Шаблон:', 'template_id', $tplOptions, $tplDefault));
            
            $configs = Container::get('Pdf/PdfConfigModel')->selectEntity(array(), array('id','title'));
            $confOptions = array();
            foreach ($configs as $row => $data) {
                $confOptions[$data['id']] = $data['title'];
            }
            $confDefault = array();
            if (isset($values['config_id'])) {
                $confDefault[$values['config_id']] = $confOptions[$values['config_id']];
            }
            $form->addElement(new Element\Select('Конфігурація:', 'config_id', $confOptions));
            
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

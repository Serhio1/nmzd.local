<?php

namespace Src\Modules\Entity\Forms;

use App\Core\BaseForm;
use App\Core\IForm;
use App\Core\Router;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Symfony\Component\HttpFoundation\Request;
use Src\Modules\Admin\Models\AdminModel;
use App\Core\Container;

class EntityForm extends BaseForm
{
    protected $formName;

    protected $steps = array(
        'entityFormProcess',
    );

    public function getEntity()
    {
        return Container::get($this->entity);
    }

    protected function entityFormProcess($form, $request, $config)
    {
        if ($this->operation == 'update') {
            $id = $request->query->get('id');
            $values = $this->getEntity()->selectById($id);
        } else {
            $values = array();
        }
        $parent = Container::get($this->entity)->getParent();
        $entityConfig = $this->config();
        if (!empty($entityConfig['view'])) {
            $view = '\\PFBC\\View\\' . ucfirst($entityConfig['view']);
            $entityConfig['view'] = new $view;
        }
        $form->configure(array_merge($entityConfig, $config));
        $form->addElement(new Element\Hidden($this->formName, $this->formName));
        if ($this->operation == 'create') {
            $form->addElement(new Element\Hidden($parent . '_id', $request->query->get('id')));
        } elseif ($this->operation == 'update') {
            $form->addElement(new Element\Hidden('id', $request->query->get('id')));
            if (!empty($parent)) {
                $id = $request->query->get('id');
                $parent_id = Container::get($this->entity)->getParentId($id);
                $form->addElement(new Element\Hidden($parent . '_id', $parent_id['0'][$parent . '_id']));
            }
        } elseif ($this->operation == 'delete') {
            $form->addElement(new Element\Hidden('id', $request->query->get('id')));
            if (!empty($parent)) {
                $id = $request->query->get('id');
                $parent_id = Container::get($this->entity)->getParentId($id);
                $form->addElement(new Element\Hidden($parent . '_id', $parent_id['0'][$parent . '_id']));
            }
        }


        $form = $this->defineFields($form, $values, $this->operation);

        return $form;
    }

    protected function defineFields($form, $values = array(), $operation){}

    protected function config(){}

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

    }

    protected function finishEvent($vars = array())
    {
        Container::get('router')->redirect($_SESSION[$this->formName]['action']);
    }

}
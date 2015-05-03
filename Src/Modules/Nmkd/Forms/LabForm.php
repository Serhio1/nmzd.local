<?php

namespace Src\Modules\Nmkd\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use Src\Modules\Nmkd\Forms\Elements\LabCKEditor\LabCKEditor;
use App\Core\Container;

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
            $form->addElement(new Element\Button('Видалити'));
        } else {
            
            if ($operation == 'create') {
                $form->addElement(new Element\HTML('<legend>Створення нової лабораторної</legend>'));
                $form->addElement(new Element\Hidden('theme'));
                $form->addElement(new Element\Hidden('type'));
                $form->addElement(new Element\Hidden('purpose'));
                $form->addElement(new Element\Hidden('theory'));
                $form->addElement(new Element\Hidden('execution_order'));
                $form->addElement(new Element\Hidden('content_structure'));
                $form->addElement(new Element\Hidden('requirements'));
                $form->addElement(new Element\Hidden('individual_variants'));
                $form->addElement(new Element\Hidden('literature'));
                $form->addElement(new Element\Textbox('Назва:', 'title', array(
                    'required' => 1,
                    'value' => empty($values['title']) ? '' : $values['title'],
                )));
                

                // easy to break. If not working, check ckeditor id in lab_form_process.js
                $form->addElement(new LabCKEditor('Текст лабораторної:', 'body'));
                $form->addElement(new Element\HTML('<script type="text/javascript" src="/Src/Modules/Nmkd/Forms/Elements/LabCKEditor/js/lab_form_process.js"></script>'));
            }
            if ($operation == 'update') {
                $form->addElement(new Element\HTML('<legend>Редагування лабораторної</legend>'));
                $form->addElement(new Element\Textbox('Назва:', 'title', array(
                    'required' => 1,
                    'value' => empty($values['title']) ? '' : $values['title'],
                )));
                $form->addElement(new Element\Textarea('Тема:', 'theme', array(
                    'value' => $values['theme']
                )));
                $form->addElement(new Element\Textarea('Вид заняття:', 'type', array(
                    'value' => $values['type']
                )));
                $form->addElement(new Element\Textarea('Мета:', 'purpose', array(
                    'value' => $values['purpose']
                )));
                $form->addElement(new Element\Textarea('Теоретичний матеріал:', 'theory', array(
                    'value' => $values['theory']
                )));
                $form->addElement(new Element\Textarea('Порядок виконання:', 'execution_order', array(
                    'value' => $values['execution_order']
                )));
                $form->addElement(new Element\Textarea('Структура змісту текстових розділів звітних матеріалів:', 'content_structure', array(
                    'value' => $values['content_structure']
                )));
                $form->addElement(new Element\Textarea('Вимоги до оформлення роботи та опис процедури її захисту:', 'requirements', array(
                    'value' => $values['requirements']
                )));
                $form->addElement(new Element\Textarea('Варіанти індивідуальних завдань:', 'individual_variants', array(
                    'value' => $values['individual_variants']
                )));
                $form->addElement(new Element\Textarea('Рекомендована література:', 'literature', array(
                    'value' => $values['literature']
                )));
            }
            

            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            $form->addElement(new Element\Button('Зберегти', 'submit'));
            
            
        }

        return $form;
    }
    
    
    public function submit(Request $request, $form)
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
            
            //$_SESSION[$this->formName]['action'] = $id['0']['id'];
            //$vars['id'] = $id['0']['id'];
        }
        if ($this->operation == 'update') {
            $entity->updateEntity($params, array('id' => $id));
            //$vars['parent_id'] = $entity->getParentId($id);
        }
        if ($this->operation == 'delete') {
            $entity->deleteEntity(array('id' => $id));
            //$vars['parent_id'] = $entity->getParentId($id);
        }

        $step = $request->request->get('step');
        if ($step == 'finish') {
            $this->finishEvent($vars);
        }

    }
    
    protected function finishEvent($vars = array())
    {
        if (!empty($vars['parent_id'])) {
            Container::get('router')->redirect(explode('?' ,$_SESSION[$this->formName]['action'])[0] . '?id=' . $vars['parent_id']);
        }
        Container::get('router')->redirect($_SESSION[$this->formName]['action'] /*. '?id=' . $vars['parent_id']*/);
    }

}
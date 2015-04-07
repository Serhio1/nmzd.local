<?php

namespace Src\Modules\Nmkd\Forms;

use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use App\Core\Container;
use App\Core\BaseForm;
use Src\Modules\Nmkd\Forms\Elements\Hierarchy\Hierarchy;
use Src\Modules\Nmkd\Forms\Elements\CheckboxMatrix\CheckboxMatrix;

class NmkdForm extends BaseForm
{
    protected $formName = 'nmkd_form';
    
    protected $steps = array(
        'input',
        'setHierarchy',
        'setTypes',
    );
    
    protected $entity = 'Nmkd/NmkdModel';
    
    public function getEntity()
    {
        return Container::get($this->entity);
    }

    /**
     * First step. Adding initial data.
     * 
     * @param type $form
     * @param type $request
     * @param type $config
     * @return type
     */
    public function input($form, $request, $config)
    {
        $questionsStr = '';
        if (!empty($_SESSION[$this->formName]['questions'])) {
            $questions = $_SESSION[$this->formName]['questions'];
            $questionsStr = implode($questions, "\r\n");
        }    
        $form->addElement(new Element\HTML('<legend>Введіть запитання</legend>'));
        $form->addElement(new Element\Textarea('', 'questions', array(
            'required' => 1,
            'value' => $questionsStr
        )));
        
        $form->addElement(new Element\Button('Відмінити', 'button', array(
            'onclick' => 'history.go(-1);'
        )));
        $form->addElement(new Element\Button('Далі', 'submit'));
   
        return $form;
    }
    
    /**
     * Processor for first step.
     * 
     * @param type $request
     */
    protected function inputProcess($request)
    {
        $questionStr = $request->request->get('questions');
        $questionArr = explode('<br />', nl2br($questionStr));
        $questionArr = array_map('trim',$questionArr);
        $questionArr = array_filter($questionArr);
    
        $_SESSION[$this->formName]['questions'] = $questionArr;
    }

    /**
     * Second step. Setting question structure.
     * 
     * @param type $form
     * @param type $request
     * @param type $config
     * @return type
     */
    public function setHierarchy($form, $request, $config)
    {
        $this->inputProcess($request);
        
        $form->addElement(new Element\HTML('<legend>Визначте структуру запитань</legend>'));
        
        
        $form->addElement(new Hierarchy('Структура:', 
                'hierarchy', 
                array(
                    'content' => $_SESSION[$this->formName]['questions'],
                    'groups' => array(
                        'Змістовий модуль',
                        'Тема',
                        'Запитання',
                    ),
                    'default' => 'Запитання'
                )
        ));
        
        $form->addElement(new Element\Button('Назад', 'button', array(
            'onclick' => 'history.go(-1);'
        )));
        $form->addElement(new Element\Button('Далі', 'submit'));
        
        return $form;
    }
    
    /**
     * Processor for second step.
     * 
     * @param type $request
     */
    protected function setHierarchyProcess($request)
    {
        $_SESSION[$this->formName]['hierarchy'] = $request->request->get('hierarchy');
    }
    
    public function setTypes($form, $request, $config)
    {
        $this->setHierarchyProcess($request);
        
        $types = Container::get('Nmkd/TypesModel')->getEntityList();
        $typesArr = array();
        $questionArr = array();
        $hierarchyArr = array();
        
        foreach ($types as $row => $values) {
            $typesArr[$values['id']] = $values['title'];
        }
        
        foreach ($_SESSION[$this->formName]['hierarchy'] as $hKey => $hVal) {
            $hierarchyArr[strstr($hVal, '-', true)] = ltrim(strstr($hVal, '-'), '-');
        }
        
        foreach ($_SESSION[$this->formName]['questions'] as $qKey => $question) {
            $questionArr[$qKey]['title'] = $question;
            if ($hierarchyArr[$qKey] == '0') {
                $questionArr[$qKey]['no-check'] = true;
            }
            if ($hierarchyArr[$qKey] == '1') {
                $questionArr[$qKey]['check-col'] = true;
            }
        }
        
        $form->addElement(new Element\HTML('<legend>Оберіть типи запитань</legend>'));
        $form->addElement(new CheckboxMatrix("Типи:", "types", array(
            'vertical' => $questionArr,
            'horizontal' => $typesArr
        )));
        
        $form->addElement(new Element\Button('Назад', 'button', array(
            'onclick' => 'history.go(-1);'
        )));
        $form->addElement(new Element\Button('Зберегти', 'submit'));
        
        return $form;
    }
    
    /**
     * Processor for third step.
     * 
     * @param type $request
     */
    protected function setTypesProcess($request)
    {
        $types = array();
        foreach ($request->request->get('types') as $key => $val) {
            $types[$key] = $val[0];
        }
        $_SESSION[$this->formName]['types'] = $types;
    }
    
    public function submit(Request $request)
    {
        $this->setTypesProcess($request);
        dump($_SESSION);
        dump($_POST);
        
        $questions = $_SESSION[$this->formName]['questions'];
        $typesQuestions = $_SESSION[$this->formName]['types'];
        $typesQuestionsRes = array();
        foreach ($typesQuestions as $key => $typeQuestion) {
            $typeQuestionExp = explode('-', $typeQuestion);
            $typesQuestionsRes[$typeQuestionExp[0]][] = $typeQuestionExp[1];
        }
        
        $hierarchy = $_SESSION[$this->formName]['hierarchy'];
        $hierarchyRes = array();
        foreach ($hierarchy as $key => $pair) {
            $pairArr = explode('-', $pair);
            $hierarchyRes[$pairArr[0]] = $pairArr[1];
        }
        
        $disciplineId = $request->query->get('id');
        $entity = $this->getEntity();
        $entity->createEntity($questions, $disciplineId, $typesQuestionsRes, $hierarchyRes);
        //$vars['id'] = $id['0']['id'];
        
        
        
        die();
    }

}


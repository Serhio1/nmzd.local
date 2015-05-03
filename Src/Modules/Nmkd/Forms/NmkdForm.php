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
        $idDiscipline = $request->query->get('id');
        $entity = $this->getEntity();
        /*if ($this->operation == 'create') {
            $questionsStr = '';
            if (!empty($_SESSION[$this->formName][$request->query->get('id')]['questions'])) {
                $questions = $_SESSION[$this->formName][$request->query->get('id')]['questions'];
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
        }
        
        if ($this->operation == 'update') {*/
        $questionsStr = '';
        if (!empty($_SESSION[$this->formName][$request->query->get('id')]['questions'])) {
            $questions = $_SESSION[$this->formName][$request->query->get('id')]['questions'];
            $questionsStr = implode($questions, "\r\n");
        } else {
            $selection = $this->getEntity()->selectEntity($idDiscipline);
            $questionsStr = '';
            foreach ($selection as $row=>$data) {
                $questionsStr .= $data['name'] . "\r\n";
            }
        }
        $form->addElement(new Element\HTML('<legend>Введіть запитання</legend>'));
        $form->addElement(new Element\Textarea('', 'questions', array(
            'required' => 1,
            'value' => $questionsStr
        )));
        
        $form = $this->addControls($form, $request);
            
        return $form;
    }
    
    /**
     * Processor for first step.
     * 
     * @param type $request
     */
    protected function inputProcessor($request)
    {
        $questionStr = $request->request->get('questions');
        $questionArr = explode('<br />', nl2br($questionStr));
        $questionArr = array_map('trim',$questionArr);
        $questionArr = array_filter($questionArr);
    
        $_SESSION[$this->formName][$request->query->get('id')]['questions'] = $questionArr;
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
        //$this->inputProcess($request);
        
        /*if ($this->operation == 'create') {
            
            $form->addElement(new Element\HTML('<legend>Визначте структуру запитань</legend>'));
            $form->addElement(new Hierarchy('Структура:', 
                'hierarchy', 
                array(
                    'content' => $_SESSION[$this->formName][$request->query->get('id')]['questions'],
                    'groups' => array(
                        'Змістовий модуль',
                        'Тема',
                        'Запитання',
                    ),
                    'default' => 'Запитання',
                    'value' => $value
                )                
            ));
        }
        if ($this->operation == 'update') {*/
            $disciplineId = $request->query->get('id');
            $entity = $this->getEntity();
            $hierarchy = $entity->selectQuestionHierarchy($disciplineId);
            $value = array();
            if (!empty($hierarchy)) {
                $value = $hierarchy;
            }
            $form->addElement(new Element\HTML('<legend>Визначте структуру запитань</legend>'));
        
        
            $form->addElement(new Hierarchy('Структура:', 
                'hierarchy', 
                array(
                    'content' => $_SESSION[$this->formName][$request->query->get('id')]['questions'],
                    'groups' => array(
                        'Змістовий модуль',
                        'Тема',
                        'Запитання',
                    ),
                    'default' => 'Запитання',
                    'value' => $value
                )                
            ));
        //}
        
        $form = $this->addControls($form, $request);
        
        return $form;
    }
    
    /**
     * Processor for second step.
     * 
     * @param type $request
     */
    protected function setHierarchyProcessor($request)
    {
        $_SESSION[$this->formName][$request->query->get('id')]['hierarchy'] = $request->request->get('hierarchy');
    }
    
    public function setTypes($form, $request, $config)
    {
        //$this->setHierarchyProcess($request);
        
        $disciplineId = $request->query->get('id');
        $existTypes = $this->getEntity()->selectTypes($disciplineId);
        $value = array();
        foreach ($existTypes as $row => $val) {
            $value[$val['num_tq']] = $val['types_id'];
        }
        
        $types = Container::get('Nmkd/TypesModel')->getEntityList();
        $typesArr = array();
        $questionArr = array();
        $hierarchyArr = array();
        
        foreach ($types as $row => $values) {
            $typesArr[$values['id']] = $values['title'];
        }
        
        foreach ($_SESSION[$this->formName][$request->query->get('id')]['hierarchy'] as $hKey => $hVal) {
            $hierarchyArr[strstr($hVal, '-', true)] = ltrim(strstr($hVal, '-'), '-');
        }
        
        foreach ($_SESSION[$this->formName][$request->query->get('id')]['questions'] as $qKey => $question) {
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
            'horizontal' => $typesArr,
            'value' => $value
        )));
        
        $form = $this->addControls($form, $request);
        
        return $form;
    }
    
    /**
     * Processor for third step.
     * 
     * @param type $request
     */
    protected function setTypesProcessor($request)
    {
        $types = array();
        if (!empty($request->request->get('types'))) {
            foreach ($request->request->get('types') as $key => $val) {
                $types[$key] = $val;
            }
        }
        $_SESSION[$this->formName][$request->query->get('id')]['types'] = $types;
    }
    
    public function submit(Request $request, $form)
    {
        $vars = array();
        /*if ($this->operation == 'create') {
            $vars['discipline_id'] = $request->query->get('id');
            $this->setTypesProcess($request);

            $questions = $_SESSION[$this->formName][$request->query->get('id')]['questions'];
            $typesQuestions = $_SESSION[$this->formName][$request->query->get('id')]['types'];
            $typesQuestionsRes = array();
            foreach ($typesQuestions as $key => $typeQuestion) {
                $typeQuestionExp = explode('-', $typeQuestion);
                $typesQuestionsRes[$typeQuestionExp[0]][] = $typeQuestionExp[1];
            }

            $hierarchy = $_SESSION[$this->formName][$request->query->get('id')]['hierarchy'];
            $hierarchyRes = array();
            foreach ($hierarchy as $key => $pair) {
                $pairArr = explode('-', $pair);
                $hierarchyRes[$pairArr[0]] = $pairArr[1];
            }

            $disciplineId = $request->query->get('id');
            $entity = $this->getEntity();
            $entity->updateEntity($questions, $disciplineId, $typesQuestionsRes, $hierarchyRes);
            
        }
        if ($this->operation == 'update') {*/
            $vars['discipline_id'] = $request->query->get('id');
            //$this->setTypesProcess($request);

            $questions = $_SESSION[$this->formName][$request->query->get('id')]['questions'];
            $typesQuestions = $_SESSION[$this->formName][$request->query->get('id')]['types'];
            $typesQuestionsRes = array();
            foreach ($typesQuestions as $key => $typeQuestion) {
                $typeQuestionExp = explode('-', $typeQuestion);
                $typesQuestionsRes[$typeQuestionExp[0]][] = $typeQuestionExp[1];
            }

            $hierarchy = $_SESSION[$this->formName][$request->query->get('id')]['hierarchy'];
            $hierarchyRes = array();
            foreach ($hierarchy as $key => $pair) {
                $pairArr = explode('-', $pair);
                $hierarchyRes[$pairArr[0]] = $pairArr[1];
            }

            $disciplineId = $request->query->get('id');
            $entity = $this->getEntity();
            $entity->updateEntity($questions, $disciplineId, $typesQuestionsRes, $hierarchyRes);
            
        //}
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


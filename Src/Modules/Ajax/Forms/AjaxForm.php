<?php

namespace Src\Modules\Ajax\Forms;

use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use App\Core\Container;
use App\Core\BaseForm;

class AjaxForm extends BaseForm
{
    protected $formName = 'ajax_form';
    
    protected $steps = array(
        'input',
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
        $ajax = $request->isXmlHttpRequest();
        $questionStr = $request->request->get('questions');
        $questionArr = explode('<br />', nl2br($questionStr));
        $questionArr = array_map('trim',$questionArr);
        $questionArr = array_filter($questionArr);
    
        $_SESSION[$this->formName][$request->query->get('id')]['questions'] = $questionArr;
    }


    public function submit(Request $request, $form)
    {
        $vars = array();
        
        $vars['discipline_id'] = $request->query->get('id');
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



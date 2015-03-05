<?php

namespace Src\Modules\Nmkd\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use Src\Modules\Nmkd\Views\LabCKEditor;
use App\Core\Container;
use App\Core\BaseForm;
use Src\Modules\Nmkd\Forms\Elements\Hierarchy\Hierarchy;

class NmkdForm extends BaseForm
{
    protected $formName = 'nmkd_form';
    
    protected $steps = array(
        'input',
        'setHierarchy',
        'setTypes',
    );

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
        
        return $form;
    }
    
    public function submit(Request $request)
    {
        if ($this->operation == 'check_password') {
            if ($request->request->get('password') == Container::get('params')->adminPassword) {
                $_SESSION['security_access'] = true;
            }
        }
    }

}


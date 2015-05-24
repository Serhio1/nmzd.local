<?php

namespace App\Core;

use App\Core\IForm;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;

class BaseForm
{
    
    public function __construct($operation)
    {
        $this->operation = $operation;
    }

    public function getFormName()
    {
        return $this->formName;
    }
    
    public function setFormName($name)
    {
        $this->formName = $name;
    }

    /**
     *
     * @param $request
     * @param array $config - array, contains keys
     *      'action' => string 'index.php'
     *      'id' => string 'gen_module'
     *      'method' => string 'post'
     *      'view' => new View\Vertical
     * @return Form
     */
    public function build($request, $config = array())
    {
        if (!empty($_SERVER["QUERY_STRING"])) {
            $config['action'] .= '?' . $_SERVER["QUERY_STRING"];
        }
        if ($request->isXmlHttpRequest()) {
            $post = array();
            parse_str($request->request->get('ajaxData')['data'], $post);
            foreach ($post as $key => $val) {
                $request->request->set($key, $val);
                $_POST[$key] = $val;
            }
        } else {
            $_SESSION[$this->formName]['action'] = $config['action'];
            $config['action'] = '';
        }
        
        $form = new Form($this->getFormName());
        
        
        $callback = $this->steps[count($this->steps)-1];
       // $config['action'] = $_SESSION[$this->formName]['action'];
        $processor = $callback . 'Processor';
        
        if ($request->request->get('step') == 'finish') {
            $callback = $this->steps[count($this->steps)-1];
            $config['action'] = $_SESSION[$this->formName]['action'];
            $processor = $callback . 'Processor';
            if (method_exists($this, $processor)) {
                $this->$processor($request);
            }
            
            //$form = $this->$callback($form, $request, $config);
            //$form = $this->$callback($form, $request, $config);
            $formRequest = $request->request->get($this->formName);
            if (Form::isValid($this->formName)) {
                //if ($form->validate($request, $formInstance)) {
                    $this->submit($request, $form);
                    $this->finishEvent();
                    return $form;
                //}
            } else {
                $request->request->set('step', count($this->steps)-1);
            }
          
            //$this->submit($request, $form);
            
        }
        
        
        if (empty($this->steps)) {
            throw new \Exception('Form requires at least one step.');
        }
        $requestedStep = $request->request->get('step');
        if (empty($requestedStep)) {
            $requestedStep = 0;
        } else {
            if (!Form::isValid($this->formName)) {
                if ($requestedStep >= 1) {
                    $processor = $this->steps[$requestedStep-1];
                    $form = $this->$processor($form, $request, $config);
                    $form->configure($config);
                    return $form;
                } elseif ($requestedStep == 0) {
                    $processor = $this->steps[0];
                    $form = $this->$processor($form, $request, $config);
                    $form->configure($config);
                    return $form;
                }
            }
        }
        
        
            $requestedStep++;
            $processor = $requestedStep-2;
            if ($processor >= 0) {
                $stepProcessor = $this->steps[$processor] . 'Processor';
                $this->$stepProcessor($request);
            }
            if (empty($this->steps[$requestedStep])) {
                $form->addElement(new Element\Hidden('step', 'finish'));
                //$config['action'] = $_SESSION[$this->formName]['action'];
                //unset($_SESSION[$this->formName]['action']);
            } else {
                $form->addElement(new Element\Hidden('step', $requestedStep));
                //$config['action'] = '';
            }
            $requestedStep--;
            $callback = $this->steps[$requestedStep];
            $form = $this->$callback($form, $request, $config);
            $form->configure($config);
            
            
            
            /*$formRequest = $request->request->get($this->formName);
            if (!empty($formRequest) && $formRequest == $formName) {
                if (Form::isValid($this->formName)) {
                    if ($form->validate($request, $formInstance)) {
                        $form->submit($request, $formInstance);
                    }
                }
            }*/

        return $form;
    }
    
    
    protected function addControls($form, Request $request)
    {
        if ($this->operation == 'delete') {
            $form->addElement(new Element\Button('Відмінити', 'button', array(
                'onclick' => 'history.go(-1);'
            )));
            if ($request->isXmlHttpRequest()) {
                $form->addElement(new Element\Button('Видалити','button',array('class'=>'ajax-submit')));
            } else {
                $form->addElement(new Element\Button('Видалити', 'submit', array()));
            }
        } else {
            $form->addElement(new Element\Button('Відмінити', 'button', array(
            'onclick' => 'history.go(-1);'
            )));
            if ($request->isXmlHttpRequest()) {
                $form->addElement(new Element\Button('Зберегти','button',array('class'=>'ajax-submit')));
            } else {
                $form->addElement(new Element\Button('Зберегти', 'submit'));
            }
        }
        $form->addElement(new Element\HTML('<script type="text/javascript">$("#'.$this->formName.'").submit(function(e){ setInterval(function(){$(\'input[type=submit]\').prop("disabled", false);}, 10); }); </script>'));
        
        return $form;
    }

    /**
     * @TODO: Add functionality for validation.
     *
     * @param Request $request
     * @return bool
     */
    public function validate(Request $request, $form)
    {
        return true;
    }
    
    public function submit(Request $request, $form){}
    
    protected function finishEvent()
    {
        Container::get('router')->redirect($_SESSION[$this->formName]['action']);
    }

}

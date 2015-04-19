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
            parse_str($request->request->get('ajaxData'), $post);
            foreach ($post as $key => $val) {
                $request->request->set($key, $val);
            }
        } else {
            $_SESSION[$this->formName]['action'] = $config['action'];
            $config['action'] = '';
        }
        
        if ($request->request->get('step') == 'finish') { 
            $config['action'] = $_SESSION[$this->formName]['action'];
            $this->submit($request);
            $this->finishEvent();
        }
        $form = new Form($this->getFormName());
        
        if (empty($this->steps)) {
            throw new \Exception('Form requires at least one step.');
        }
        $requestedStep = $request->request->get('step');
        if (empty($requestedStep)) {
            $requestedStep = 0;
        }
            $requestedStep++;
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

        return $form;
    }
    
    
    protected function addControls($form, Request $request)
    {
        $form->addElement(new Element\Button('Відмінити', 'button', array(
            'onclick' => 'history.go(-1);'
        )));
        if ($request->isXmlHttpRequest()) {
            $form->addElement(new Element\Button('Зберегти','button',array('class'=>'ajax-submit')));
        } else {
            $form->addElement(new Element\Button('Зберегти', 'submit'));
        }
        
        return $form;
    }

    /**
     * @TODO: Add functionality for validation.
     *
     * @param Request $request
     * @return bool
     */
    public function validate(Request $request)
    {
        return true;
    }
    
    public function submit(Request $request){}
    
    protected function finishEvent()
    {
        Container::get('router')->redirect($_SESSION[$this->formName]['action']);
    }

}

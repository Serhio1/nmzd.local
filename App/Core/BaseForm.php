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
        $form = new Form($this->getFormName());
        $_SESSION[$this->formName]['action'] = $config['action'];
        $config['action'] = '';

        if (empty($this->steps)) {
            throw new \Exception('Form requires at least one step.');
        }
        $requestedStep = $request->request->get('step');
        if (empty($requestedStep)) {
            $requestedStep = 0;
        }
        
        if ($requestedStep == 'finish') {
            $config['action'] = '';
            if (!empty($_SERVER["QUERY_STRING"])) {
                $config['action'] .= '?' . $_SERVER["QUERY_STRING"];
            }
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
        /*if (!empty($_SERVER["QUERY_STRING"])) {
            $config['action'] .= '?' . $_SERVER["QUERY_STRING"];
        }*/
        
        $requestedStep--;
        $callback = $this->steps[$requestedStep];
        
        $form = $this->$callback($form, $request, $config);
        $form->configure($config);
        
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

}

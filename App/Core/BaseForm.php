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
        $_SESSION[$this->formName]['action'] = $config['action'];

        if (empty($this->steps)) {
            throw new \Exception('Form requires at least one step.');
        }
        $requestedStep = $request->query->get('step');
        if (empty($requestedStep)) {
            $requestedStep = 0;
        }

        $requestedStep++;
        $form = new Form($this->getFormName());
        if (empty($this->steps[$requestedStep])) {
            $form->addElement(new Element\Hidden('step', 'finish'));
        } else {
            $form->addElement(new Element\Hidden('step', $requestedStep));
        }
        $config['action'] = '?' . $_SERVER["QUERY_STRING"];

        $requestedStep--;
        $callback = $this->steps[$requestedStep];
        $form = $this->$callback($form, $request, $config);

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

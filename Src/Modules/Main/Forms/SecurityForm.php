<?php

namespace Src\Modules\Main\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use Src\Modules\Nmkd\Views\LabCKEditor;
use App\Core\Container;
use App\Core\BaseForm;
use Src\Modules\Main\Forms\Validation\Md5;

class SecurityForm extends BaseForm
{
    protected $formName = 'security_form';
    
    protected $steps = array(
        'securityFormProcess',
    );
    
    protected function securityFormProcess($form, $request, $config)
    {
        if ($this->operation == 'check_password') {
            $form->addElement(new Element\HTML('<legend>Введіть пароль доступу</legend>'));
            $form->addElement(new Element\Password('Пароль:', 'password', array(
                'required' => 1,
                "validation" => new Md5("/" . Container::get('params')->adminPassword . "/", "Error: Неправильний пароль."),
            )));
            $form->addElement(new Element\Captcha('Капча:', array(
                'required' => 1,
            )));
        }
        $this->addControls($form, $request);
        
        return $form;
    }
    
    public function submit(Request $request, $form)
    {
        if ($this->operation == 'check_password') {
            $_SESSION['security_access'] = true;
        }
        $this->finishEvent();
    }

}


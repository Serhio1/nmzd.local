<?php

namespace Src\Modules\Main\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use Src\Modules\Nmkd\Views\LabCKEditor;
use App\Core\Container;
use App\Core\BaseForm;

class SecurityForm extends BaseForm
{
    protected $formName = 'security_form';
    
    protected $steps = array(
        'securityFormProcess',
    );
    
    protected function securityFormProcess($form, $request, $config)
    {
        $form->configure($config);
        
        if ($this->operation == 'check_password') {
            $form->addElement(new Element\HTML('<legend>Введіть пароль доступу</legend>'));
            $form->addElement(new Element\Password('Пароль:', 'password', array(
                'required' => 1,
            )));
        }
        
        $form->addElement(new Element\Button('Відмінити', 'button', array(
            'onclick' => 'history.go(-1);'
        )));
        $form->addElement(new Element\Button('Зберегти', 'submit'));
        
        
        /*$step = $request->request->get('step');
        if ($step == 'finish') {
            $this->submit($request);
        }*/
        
        return $form;
    }
    
    public function submit(Request $request)
    {
        if ($this->operation == 'check_password') {
            if ($request->request->get('password') == Container::get('params')->adminPassword) {
                $_SESSION['security_access'] = true;
            }
        }
        $this->finishEvent();
        
        
    }

}


<?php

namespace Src\Modules\Pdf\Forms;

use App\Core\BaseForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use App\Core\Container;
use Src\Modules\Pdf\Forms\Elements\PdfCKEditor\PdfCKEditor;

class PdfEditor extends BaseForm
{
protected $formName = 'nmkd_form';
    
    protected $steps = array(
        'edit',
    );

    /**
     * First step. Adding initial data.
     * 
     * @param type $form
     * @param type $request
     * @param type $config
     * @return type
     */
    public function edit($form, $request, $config)
    {
        $form->addElement(new Element\HTML('<legend>Створення нової конфігурації</legend>'));
        $form->addElement(new PdfCKEditor('', 'body', array(
            'value' => $request->request->get('pdf'),
        )));
        $this->addControls($form, $request);
        
        return $form;
    }
    
    /**
     * Processor for first step.
     * 
     * @param type $request
     */
    protected function editProcessor($request)
    {
        
    }
    
    
    public function submit(Request $request, $form)
    {
        
    }
    
    protected function finishEvent($vars = array())
    {
        if (!empty($vars['parent_id'])) {
            Container::get('router')->redirect(explode('?', $_SESSION[$this->formName]['action'])[0] . '?id=' . $vars['parent_id']);
        }
        Container::get('router')->redirect($_SESSION[$this->formName]['action']);
    }

}

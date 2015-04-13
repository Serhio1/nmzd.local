<?php

namespace Src\Modules\Admin\Forms;

use App\Core\BaseForm;
use App\Core\IForm;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Symfony\Component\HttpFoundation\Request;
use Src\Modules\Admin\Models\AdminModel;
use App\Core\Container;
use App\Core\Router;

class ModuleListForm extends BaseForm
{
    protected $formName = 'modules_list';

    protected $steps = array(
        'formProcess',
    );

    protected function formProcess($form, $request, $config)
    {
        $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json');
        $modulesConf = json_decode($modulesConfJson);

        $form->configure($config);

        $form->addElement(new Element\HTML('<legend>Список модулів</legend>'));
        $form->addElement(new Element\Hidden($this->formName, $this->formName));

        $options = array();
        $hidden = array();
        $enabledModules = array();
        
        foreach ($modulesConf as $name => $state) {
            $options[$name] = $name;
            if ($state) {
                $enabledModules[$name] = $name;
            }
        }
        
        $form->addElement(new Element\Checkbox("Modules", "Modules", $options, array(
            "value" => $enabledModules,
            "class" => $hidden
        )));
        $form->addElement(new Element\Button("Зберегти"));
        $form->addElement(new Element\Button("Відмінити", "button", array(
            "onclick" => "history.go(-1);"
        )));

        return $form;
    }

    public function validate(Request $request)
    {
        return true;
    }

    public function submit(Request $request)
    {
        $requestedModules = $request->request->get('Modules');
        $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json');
        $modulesConf = json_decode($modulesConfJson, true);
        $modulesConf = array_fill_keys(array_keys($modulesConf), false);
        foreach ($requestedModules as $key => $mName) {
            $modulesConf[$mName] = true;
        }
        file_put_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json', json_encode($modulesConf));
        Container::get('router')->redirect('/admin');
    }


    public function getFormName()
    {
        return $this->formName;
    }

    public function setFormName($name)
    {
        $this->formName = $name;
    }
}

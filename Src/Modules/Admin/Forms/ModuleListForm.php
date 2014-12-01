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

class ModuleListForm extends BaseForm
{
    protected $formName = 'modules_list';

    protected $steps = array(
        'formProcess',
    );

    protected function formProcess($form, $request, $config)
    {

        $model = Container::get('Main/ModuleModel');
        $modules = $model->getModules();

        /*if (!empty($config['view'])) {
            $view = '\\PFBC\\View\\' . ucfirst($config['view']);
            $config['view'] = new $view;
        }

        $config = array_merge($config, array("prevent" => array("bootstrap", "jQuery")));*/

        $form->configure($config);

        $form->addElement(new Element\HTML('<legend>Список модулів</legend>'));
        $form->addElement(new Element\Hidden($this->formName, $this->formName));

        $options = array();
        $hidden = array();
        $enabledModules = array();
        foreach ($modules as $module) {
            $options[$module['id']] = $module['name'];
            if ($module['state']) {
                $enabledModules[$module['id']] = $module['id'];
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
        $currentModules = $request->request->get('Modules');
        $model = Container::get('Main/ModuleModel');
        $modules = $model->getModules();

        $res = array();
        foreach ($modules as $row) {
            if (in_array($row['id'], $currentModules)) {
                $res[$row['id']] =  1;
                $moduleStr = 'Src\\Modules\\' . ucfirst($row['name']) . '\\Module';
                $module = new $moduleStr;
                $module->install();
            } else {
                $res[$row['id']] =  0;
            }
        }
        $model->setModuleStateMultiple($res);
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

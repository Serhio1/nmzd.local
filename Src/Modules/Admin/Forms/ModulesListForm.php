<?php

namespace Src\Modules\Admin\Forms;

use App\Core\IForm;
use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;
use Symfony\Component\HttpFoundation\Request;
use Src\Modules\Admin\Models\AdminModel;
use App\Core\Container;

class ModulesListForm implements IForm
{
    /**
     * Defines form for module generation.
     *
     * @param array $config - array, contains keys
     *      'action' => string 'index.php'
     *      'id' => string 'gen_module'
     *      'method' => string 'post'
     *      'view' => new View\Vertical
     * @return Form
     */
    public function build($config = array())
    {
        $model = Container::get('Admin/AdminModel');
        $modules = $model->getModules();

        if (!empty($config['view'])) {
            $view = '\\PFBC\\View\\' . ucfirst($config['view']);
            $config['view'] = new $view;
        }
        $form = new Form("modules_list");
        $config = array_merge($config, array("prevent" => array("bootstrap", "jQuery")));

        $form->configure($config);

        $form->addElement(new Element\HTML('<legend>Список модулів</legend>'));
        $form->addElement(new Element\Hidden("form", "modules_list"));

        $options = array();
        $hidden = array();
        $enabledModules = array();
        foreach ($modules as $module) {
            $options[$module['id']] = $module['module'];
            //$options['1_'.$module['id']] = $module['module'] . '_1';
            if ($module['state']) {
                $enabledModules[$module['id']] = $module['id'];
            }
            //$enabledModules['1_'.$module['id']] = $module['module'] . '_1';
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
        if ($this->validate($request)) {
            $currentModules = $request->request->get('Modules');
            $model = Container::get('Admin/AdminModel');
            $modules = $model->getModules();

            $res = array();
            foreach ($modules as $row) {
                if (in_array($row['id'], $currentModules)) {
                    $res[$row['id']] =  1;
                    $moduleStr = 'Src\\Modules\\' . ucfirst($row['module']) . '\\Module';
                    $module = new $moduleStr;
                    $module->install();
                } else {
                    $res[$row['id']] =  0;
                }
            }
            $model->setModuleStateMultiple($res);
        }
    }
}

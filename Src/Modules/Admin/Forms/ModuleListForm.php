<?php

namespace Src\Modules\Admin\Forms;

use App\Core\BaseForm;
use \PFBC\Element;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use Src\Modules\Admin\Models\ModuleModel;
use App\Core\FileProcessor;

class ModuleListForm extends BaseForm
{
    protected $formName = 'modules_list';

    protected $steps = array(
        'formProcess',
    );

    protected function formProcess($form, $request, $config)
    {
        if ($this->operation == 'view') {
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

            $form->addElement(new Element\Checkbox("Modules", "modules", $options, array(
                "value" => $enabledModules,
                "class" => $hidden
            )));
        }
        if ($this->operation == 'create') {
            $form->addElement(new Element\HTML('<legend>Створити модуль</legend>'));
            $form->addElement(new Element\Textbox('Назва', 'name'));
        }
        if ($this->operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити модуль? Файли модуля будуть знищені.</legend>'));
        }
        
        $this->addControls($form, $request);

        return $form;
    }

    public function validate(Request $request)
    {
        return true;
    }

    public function submit(Request $request)
    {
        if ($this->operation == 'view') {
            $requestedModules = $request->request->get('modules');
            $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json');
            $modulesConf = json_decode($modulesConfJson, true);
            $modulesConf = array_fill_keys(array_keys($modulesConf), false);
            foreach ($requestedModules as $key => $mName) {
                $modulesConf[$mName] = true;
            }
            file_put_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json', json_encode($modulesConf));
        }
        if ($this->operation == 'create') {
            if ($request->request->has('name')) {
                $name = ucfirst($request->request->get('name'));
                
                $model = new ModuleModel();
                if (!is_dir('Src/Modules/' . $name)) {
                    mkdir('Src/Modules/' . $name, 0775);
                }
                if (!is_dir('Src/Modules/' . $name . '/Controllers')) {
                    mkdir('Src/Modules/' . $name . '/Controllers', 0775);
                }
                if (!is_dir('Src/Modules/' . $name . '/Models')) {
                    mkdir('Src/Modules/' . $name . '/Models', 0775);
                }
                if (!is_dir('Src/Modules/' . $name . '/Forms')) {
                    mkdir('Src/Modules/' . $name . '/Forms', 0775);
                }
                if (!is_dir('Src/Modules/' . $name . '/Views')) {
                    mkdir('Src/Modules/' . $name . '/Views', 0775);
                }
                if (!file_exists('Src/Modules/' . $name . '/Controllers/MainController.php')) {
                    file_put_contents('Src/Modules/' . $name . '/Controllers/MainController.php', $model->getStdControllerContent($name));
                    chmod('Src/Modules/' . $name . '/Controllers/MainController.php', 0664);
                }
                if (!file_exists('Src/Modules/' . $name . '/Module.php')) {
                    file_put_contents('Src/Modules/' . $name . '/Module.php', $model->getStdModuleContent($name));
                    chmod('Src/Modules/' . $name . '/Module.php', 0664);
                }

                $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json');
                $modulesConf = json_decode($modulesConfJson, true);
                $modulesConf[strtolower($name)] = true;
                file_put_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json', json_encode($modulesConf));
            }
        }
        if ($this->operation == 'delete') {
            FileProcessor::recursiveDelete('Src/Modules/' . ucfirst($request->query->get('key')));
            $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json');
            $modulesConf = json_decode($modulesConfJson, true);
            unset($modulesConf[strtolower($request->query->get('key'))]);
            file_put_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json', json_encode($modulesConf));
            $module = 'Src\\Modules\\' . ucfirst($request->query->get('key')) . '\\Module';
            $module = new $module;
            $module->uninstall();
        }
        
        Container::get('router')->redirect('/admin/module');
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

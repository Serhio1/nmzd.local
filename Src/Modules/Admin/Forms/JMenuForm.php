<?php

namespace Src\Modules\Admin\Forms;

use App\Core\BaseForm;
use \PFBC\Element;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use Src\Modules\Admin\Forms\Elements\TreeGrid\TreeGrid;
use App\Core\Router;

class JMenuForm extends BaseForm
{
    protected $formName = 'jmenu';

    protected $steps = array(
        'formProcess',
    );
    
    public function getFormName()
    {
        return $this->formName;
    }

    public function setFormName($name)
    {
        $this->formName = $name;
    }

    protected function formProcess($form, $request, $config)
    {
        $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'menus.json');
        $modulesConf = json_decode($modulesConfJson);

        $form->configure($config);

        $form->addElement(new Element\HTML('<legend>Меню</legend>'));
        $form->addElement(new Element\Hidden($this->formName, $this->formName));
        
        $options['form_id'] = $this->formName;
        $options['buttons'] = true;
        $options['params'] = array(
            'url' => Router::buildUrl('App/Config/menus.json'),
            'treeField' => 'title',
        );
        $options['fields'] = array(
            'title' => array(
                'label' => 'Назва',
                'editor' => 'text',
            ),
            'url' => array(
                'label' => 'Url',
                'editor' => 'text',
            ),
            'text_id' => array(
                'label' => 'Унікальна назва',
                'editor' => 'text',
            ),
        );
        $form->addElement(new TreeGrid('Меню:', 'menu_order', $options));    
        $form->addElement(new Element\Button("Зберегти"));
        $form->addElement(new Element\Button("Відмінити", "button", array(
            "onclick" => "history.go(-1);"
        )));

        return $form;
    }

    public function submit(Request $request, $form)
    {
        $menuOrder = $request->request->get('menu_order');
        file_put_contents(Container::get('params')->getConfigDir() . '/' . 'menus.json', substr(stripslashes(json_encode($menuOrder, JSON_UNESCAPED_UNICODE)), 1, -1));
        Container::get('router')->redirect('/admin');
    }
    
}

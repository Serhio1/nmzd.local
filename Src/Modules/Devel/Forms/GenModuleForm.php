<?php

namespace Src\Modules\Devel\Forms;

use \PFBC\Form;
use \PFBC\Element;
use \PFBC\View;

class GenModuleForm
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
        if (!empty($config['view'])) {
            $view = '\\PFBC\\View\\' . ucfirst($config['view']);
            $config['view'] = new $view;
        }

        $form = new Form("gen_module");
        $config = array_merge($config, array("prevent" => array("bootstrap", "jQuery")));

        $form->configure($config);
        $form->addElement(new Element\HTML('<legend>Generate basic structure for module</legend>'));
        $form->addElement(new Element\Hidden("form", "gen-module"));
        $form->addElement(new Element\Textbox("Module Name:", "module_name", array(
            "required" => 1
        )));
        $form->addElement(new Element\CKEditor("CKEditor:", "CKEditor"));
        $form->addElement(new Element\Button("Generate"));
        $form->addElement(new Element\Button("Cancel", "button", array(
            "onclick" => "history.go(-1);"
        )));
        return $form;
    }

    public function validate()
    {

    }

    public function addField($id, $field)
    {
        $this->fields[$id] = $field;
    }
}
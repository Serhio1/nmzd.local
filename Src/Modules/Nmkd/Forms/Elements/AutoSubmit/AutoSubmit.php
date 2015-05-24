<?php

namespace Src\Modules\Nmkd\Forms\Elements\AutoSubmit;

use PFBC\Element;
use App\Core\Router;
use App\Core\Container;

class AutoSubmit extends Element {
    protected $options;
    
    protected $name;
    
    public function getCSSFiles() {
        return array(
            
        );
    }
    
    public function getJSFiles() {
        Container::get('params')->setThemeData(array('jsBottom' => array(
            'autosave' => '/Src/Modules/Nmkd/Forms/js/autosave.js'
        )));
        return array(
            
        );
    }

    /**
     * 
     * @param type $label
     * @param type $name
     * @param array $options - json array, compatible with easy ui treegrid element
     * @param array $properties
     */
    public function __construct($label, $name, $options, array $properties = null) {
            $this->options = $options;
            $this->name = $name;
            parent::__construct($label, $name, $properties);
    }
    
    public function render() {
        $markup = '';
        $markup .= '<div class="autosubmit">';
        $markup .= '<input type="number" min="15" max="300" class="timeout" id="' . $this->name . '" value="30" /> сек. ';
        $markup .= '<input type="button" class="btn autosave-btn" value="save" />';
        $markup .= '<div class="save-msg"></div>';
        $markup .= '</div>';
        echo $markup;
    }
}
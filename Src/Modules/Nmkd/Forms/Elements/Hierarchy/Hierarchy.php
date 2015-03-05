<?php

namespace Src\Modules\Nmkd\Forms\Elements\Hierarchy;

use PFBC\Element\Sort;
use App\Core\Router;

class Hierarchy extends Sort {

	/*public function __construct($label, $name, array $options, array $properties = null) {
		$this->options = $options;
		if(!empty($this->options) && array_values($this->options) === $this->options)
			$this->options = array_combine($this->options, $this->options);
		
		parent::__construct($label, $name, $properties);
	}*/

	protected function getOptionValue($value) {
        $position = strpos($value, ":pfbc");
        if($position !== false) {
            if($position == 0)
                $value = "";
            else
                $value = substr($value, 0, $position);
        }
        return $value;
    }
    
    
    public function getCSSFiles() {
        $cssUrl = Router::buildUrl('Src/Modules/Nmkd/Forms/Elements/Hierarchy/css/hierarchy.css');
            
        return array(
            $cssUrl,
        );
    }
    
    public function getJSFiles() {
        $jsUrl = Router::buildUrl('Src/Modules/Nmkd/Forms/Elements/Hierarchy/js/hierarchy.js');
        return array(
            $this->_form->getResourcesPath() . "/jquery-ui/js/jquery-ui.min.js",
            $jsUrl
        );
    }
        
    /**
     * Example of value: 1-0. First number - order of item, 
     * second number - group (0 by default).
     */
    public function render() {
        if(substr($this->_attributes["name"], -2) != "[]")
            $this->_attributes["name"] .= "[]";
        echo '<div id="' . $this->_attributes["id"] . '-wrapper" class="hierarchy-wrapper">';
        
        if (!empty($this->options['default'])) {
            echo '<input value="' . array_search($this->options['default'], $this->options['groups']) . '" type=text class="marker" style="width:0; height:0; visibility:hidden;">';
        } else {
            echo '<input type=text class="marker" style="width:0; height:0; visibility:hidden;">';
        }

        echo '<ul id="', $this->_attributes["id"], '">';
        foreach($this->options['content'] as $value => $text) {
            $value = $this->getOptionValue($value);
            if (!empty($this->options['default'])) {
                echo '<li class="hierarchy-element"><input type="hidden" name="', $this->_attributes["name"], '" value="', $value, '-' . array_search($this->options['default'], $this->options['groups']) . '"/><span class="header">' . $this->options['default'] . '</span><span class="content">', $text, '</span></li>';
            } else {
                echo '<li class="hierarchy-element"><input type="hidden" name="', $this->_attributes["name"], '" value="', $value, '-"/><span class="header"></span><span class="content">', $text, '</span></li>';
            }
            
        }
        echo '</ul>';
        
        echo '<ul id="' . $this->_attributes["id"] . '-groups" class="hierarchy-groups">';
        foreach($this->options['groups'] as $groupValue => $groupText) {
            if (!empty($this->options['default']) && $this->options['default'] == $groupText) {
                echo '<li class="active" value="' . $groupValue . '">' . $groupText . '</li>';
            } else {
                echo '<li value="' . $groupValue . '">' . $groupText . '</li>';
            }
            
        }
        echo '</ul>';
        echo '</div>';
    }
    
}
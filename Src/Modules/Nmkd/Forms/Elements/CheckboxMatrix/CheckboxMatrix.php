<?php

namespace Src\Modules\Nmkd\Forms\Elements\CheckboxMatrix;

use PFBC\Element\Checkbox;
use App\Core\Router;

class CheckboxMatrix extends Checkbox {
    protected $_attributes = array("type" => "checkbox");
    protected $inline;

    public function getCSSFiles() {
        $cssUrl = Router::buildUrl('Src/Modules/Nmkd/Forms/Elements/CheckboxMatrix/css/checkbox_matrix.css');
        return array(
            $cssUrl
        );
    }
    
    public function getJSFiles() {}
    
    public function render() { 
        if(isset($this->_attributes["value"])) {
            if(!is_array($this->_attributes["value"]))
                $this->_attributes["value"] = array($this->_attributes["value"]);
        }
        else
            $this->_attributes["value"] = array();

        if(substr($this->_attributes["name"], -2) != "[]")
            $this->_attributes["name"] .= "[]";

        $labelClass = $this->_attributes["type"];
        if(!empty($this->inline))
                $labelClass .= " inline";

        $count = 0;
        $i = 0;
        $checkStr = '';
        echo '<table class="checkbox-matrix table table-bordered">';
        echo '<thead><tr><th></th>';
        foreach ($this->options['horizontal'] as $horValue => $horText) {
            echo '<th>' . $horText . '</th>'; 
        }
        echo '</tr></thead><tbody>';
        
        foreach ($this->options['vertical'] as $vertValue => $vertText) {
            echo '<tr>';
            echo '<td>' . $vertText . '</td>';
            foreach ($this->options['horizontal'] as $horValue => $horText) {
                echo '<td>' . '<input id="' . $vertValue . '-' . $horValue . '" class="check-matrix-element hide" type=checkbox><label for="' . $vertValue . '-' . $horValue . '"></label>' . '</td>'; 
            }
            /*while ($i < count($this->options['horizontal'])) {
                $checkStr .= '<td></td>';
                echo $checkStr;
                $i++;
            }*/
            
            echo '</tr>';
        }
        
        echo '</tbody></table>';
        /*foreach($this->options as $value => $text) {
            $value = $this->getOptionValue($value);

            echo '<label class="', $labelClass, '"> <input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked", "required")), ' value="', $this->filter($value), '"';
            if(in_array($value, $this->_attributes["value"]))
                    echo ' checked="checked"';
            echo '/> ', $text, ' </label> ';
            ++$count;
        }*/	
    }
}


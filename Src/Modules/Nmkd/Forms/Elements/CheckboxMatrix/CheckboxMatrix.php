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
    
    public function getJSFiles() {
        $jsUrl = Router::buildUrl('Src/Modules/Nmkd/Forms/Elements/CheckboxMatrix/js/check_column.js');
        return array(
            $jsUrl
        );
    }
    
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

        echo '<table class="checkbox-matrix ' . $this->_attributes["name"] . ' table table-bordered">';
        echo '<thead><tr><th></th>';
        foreach ($this->options['horizontal'] as $horKey => $horVal) {
            echo '<th>' . $horVal . '</th>'; 
        }
        echo '</tr></thead><tbody>';
        
        foreach ($this->options['vertical'] as $vertKey => $vertVal) {
            echo '<tr>';
            if (empty($vertVal['no-check']) || $vertVal['no-check'] == false) {
                echo '<td>' . $vertVal['title'] . '</td>';
                if (!empty($vertVal['check-col']) && $vertVal['check-col'] == true) {
                    foreach ($this->options['horizontal'] as $horKey => $horVal) {
                        echo '<td>' . '<input id="' . $vertKey . '-' . $horKey . '" name="' . $this->_attributes["name"] . '[]" value="' . $vertKey . '-' . $horKey . '" class="check-matrix-element check-col" type=checkbox><label for="' . $vertKey . '-' . $horKey . '"></label>' . '</td>'; 
                    }
                } else {
                    foreach ($this->options['horizontal'] as $horKey => $horVal) {
                        echo '<td>' . '<input id="' . $vertKey . '-' . $horKey . '" name="' . $this->_attributes["name"] . '[]" value="' . $vertKey . '-' . $horKey . '" class="check-matrix-element hide" type=checkbox><label for="' . $vertKey . '-' . $horKey . '"></label>' . '</td>'; 
                    }
                }
            } else {
                $colspan = count($this->options['horizontal'])+1;
                echo '<td colspan="' . $colspan . '">' . $vertVal['title'] . '</td>';
            }
            
            echo '</tr>';
        }
        
        echo '</tbody></table>';	
    }
}


<?php

class FormManager
{
    private $forms;
    private $formData;
    private $formList;
    
    public function getForms($forms=array())
    {
        $this->forms = $forms;
        $this->formList = $forms->forms;
    }

    public function getFormData($formAlias, $validate = true)
    {
        if ($this->validateForm($formAlias)){
            foreach ($this->formList[$formAlias] as $field => $rules) {
                if (isset($_POST[$field])) {
                    $this->formData[$field] = $_POST[$field];
                } else {
                    //error: no field $field in form $formAlias
                }
            }

            return $this->formData;
        }

        if (!empty($errors)) {
            return $errors;
        }
        
        return false;
    }

    public function validateForm($formAlias)
    {       
        foreach ($this->formList[$formAlias] as $field => $rules) {
            foreach ($rules as $rule) {
                if (!isset($_POST[$field])) {
                    return false;
                }
                
                if (!$this->forms->$rule($_POST[$field], $field)) {
                    //error: field $field in $formAlias is not satisfied $rule
                    return false;
                }
            }
        }

        return true;
    }

    public function getForm($formAlias)
    {
        foreach ($this->formList[$formAlias] as $field => $rules) {
            if ($field == 'manual') {
                foreach ($rules as $rule) {
                    if (!$this->forms->$rule()) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
                
            if (isset($_POST[$field])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getFieldData($field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        }
        //error: no field in $formAlias
        
        return false;
    }

    
}

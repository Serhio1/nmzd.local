<?php

namespace App;

class Forms
{
    //formAlias => array(input_name => array(validation_rule1, validation_rule2))
    public $forms = array(
        'loginForm' => array(
            'login' => array('standardLengthRule'),
            'password' => array('standardLengthRule'),
        ),

        'registerForm' => array(
            'login' => array('standardLengthRule'),
            'password' => array('standardLengthRule','confirmRule'),
            'confirm_password' => array(),
        ),

        'nmkdInputForm' => array(
            'questions' => array('notEmptyRule'),
        ),

        'questionsHierarchyForm' => array(
            'questions_hierarchy' => array('jsonRule'),
        ),

        'typesForm' => array(
            'manual' => array('matchTypeRule'),
        ),
    );


    public function standardLengthRule($str, $field)
    {       
        if ((mb_strlen($str,'UTF-8') > 2) && ((mb_strlen($str,'UTF-8') < 21))) {
            //Container::get('errors')->addError('std_login_length');   
            return true;
        }
        
        return false;
    }

    public function confirmRule($str, $field)
    {
        if (isset($_POST['confirm_'.$field])) {
            if ($str == $_POST['confirm_'.$field]) {
                return true;
            } else {
                //error: $field is not confirmed
            }
        }
        
        return false;
    }

    public function notEmptyRule($str)
    {
        $str = trim($str);
        if ($str != '') {
            return true;
        } else {
            Container::get('errors')->addError('nmkd','no_q_inputet');
            return false;
        }
    }

    public function jsonRule($str)
    {
        if (json_decode($str, true) != null) {
            return true;
        }
        Container::get('errors')->addError('nmkd','not_valid_json');
        return false;
    }

    public function matchTypeRule()
    {
        $types = Container::get('params')->types;
        foreach ($types as $type) {
            foreach ($_POST as $field=>$val) {
                if (substr_count($field, $type)) {
                    return true;
                }
            }
        }

        return false;
    }
}

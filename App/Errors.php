<?php

namespace App;

class Errors
{
    private $errors = array(
        'global' => array(

        ),
        'nmkd' => array(
            'no_q_inputet'  => 'Не введено жодного питання',
            'no_t_selected' => 'Має бути вибране принаймні одне тематичне питання',
            'no_m_selected' => 'Має бути вибраний принаймні один змістовий модуль',
            'no_tm_connected' => 'Немає жодної прив\'язки теми до модуля',
            'no_q_selected' => 'Немає жодної прив\'язки теми до модуля',
            'not_valid_json' => 'Неправильні вхідні дані',
            'no_type_selected' => 'Має бути вибраний принаймні один тип',
        ),
        'user' => array(
            'std_login_length' => 'Логін має складатись принаймні з 3 симовлів та бути не довшим за 20 символів',
        ), 
    );

    protected static $_instance;

    private $resErrors = array();

    private function __construct(){}

    private function __clone(){}

    
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            static::$_instance = new static;
        }

        return self::$_instance;
    }
    

    public function addError($category, $error)
    {
        if (isset($this->errors[$category])) {
            if (isset($this->errors[$category][$error])) {
                $this->resErrors[] = $this->errors[$category][$error];
                $_SESSION['errors'] = $this->resErrors;
            } else {
                throw new Exception('Error \"'.$error.'\" is unregistered');
            
                return false;
            }
        } else {
            throw new Exception('Error category \"'.$category.'\" is unregistered');
            
            return false;
        }
    }

    public function outErrors()
    {
        //return $this->resErrors;
        if (isset($_SESSION['errors'])) {
            return $_SESSION['errors'];
        }
    }
}

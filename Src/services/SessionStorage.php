<?php

class SessionStorage
{

    public function __construct()
    {
        if(!isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION['storage'])) {
            $_SESSION['storage'] = '';
        }
        
        return; 
    }
    
    public function set($key, $val)
    {
        return $_SESSION['storage'][$key] = $val;
    }
    
    public function get($key)
    {
        return $_SESSION['storage'][$key];
    }
    
    public function getAll()
    {
        return $_SESSION['storage'];
    }

    public function setAll($data = array())
    {
        $_SESSION['storage'] = $data;
    }

    public function unsetAll($data = array())
    {
        unset($_SESSION['storage']);
    }

    public function isSetted($key)
    {
        if (isset($_SESSION['storage'][$key]) && sizeof($_SESSION['storage'][$key]) > 0) {
            return true;
        } else {
            return false;
        }
    }

/* get param $type - 'lection', or 'practical'...
 * return array ['theme1_name'] => array([0] => 'theme1_question1_name', [1] => 'theme1_question2_name')
 */
    public function getTypeTQ($type)
    {
        $typeThemes = $this->get($type.'_theme');
        $questions = $this->get('questions');
        $themes = $this->get('themes');

        $res = array();

        foreach ($typeThemes as $typeKey=>$themeKey) {
            $res[$questions[$themes[$themeKey]]] = $questions[$typeKey];
        }

        return $res;
    }

}

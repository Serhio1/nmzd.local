<?php

namespace App;

use App\Core\Container;

class Parameters
{
    public $dbHost = 'localhost';
    public $dbUser = 'postgres';
    public $dbPass = 'postgres';
    public $dbName = 'nmzd';
    public $dbChar = 'utf8';
    
    public $adminPassword = 'fB3hiU9'; 

    public $cache = false;

    protected $themeData = array(
        'title' => 'НМЗД',
        'layout' => '12',
        'theme' => 'Bootstrap',
    );

    protected $menus = array();

    protected static $_instance;

    private function __construct(){}

    private function __clone(){}


    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            static::$_instance = new static;
        }

        return self::$_instance;
    }

    /**
     * Returns absolute path to project directory.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname($_SERVER["SCRIPT_FILENAME"]);
    }

    public function getViewDir()
    {
        return $this->getBasePath();
    }
    
    public function getCacheDir()
    {
        return $this->getBasePath() . '/cache';
    }

    public function getThemeData()
    {
        $defaults = array(
            'global_vars' => array(
                'base_url' => Container::get('params')->getProtocol() . Container::get('params')->getBaseUrl(),
                'base_dir' => Container::get('params')->getViewDir(),
                'brand' => 'НМЗД',
                'current_url' => Container::get('params')->getProtocol() . Container::get('params')->getBaseUrl() . $_SERVER['REQUEST_URI'],
            )
        );

        $themeData = array_merge($defaults, $this->themeData);

        return $themeData;
    }

    public function setThemeData($key, $value = '')
    {
        if (is_array($key)) {
            $this->themeData =  array_merge_recursive($this->themeData, $key);
            return;
        }

        $this->themeData[$key] = $value;
    }

    public function registerMenu($name, $list = array())
    {
        if (!empty($this->menus[$name])) {
            $list = array_merge($this->menus[$name], $list);
        }
        $this->menus[$name] = $list;
    }

    public function getMenu($name)
    {
        if (isset($this->menus[$name])) {
            return $this->menus[$name];
        }
    }
//------------------------------------
    public function getPdfDir()
    {
        return $this->getBasePath() . '/src/views/pdfTemplates';
    }

    public function getMPdfLocation()
    {
        return $this->getBasePath() . '/lib/MPDF57/mpdf.php';
    }
//------------------------------------
    public function getNmkdPdfData()
    {
        return array(
            'year'                  => date('Y'),
            'order'                 => '545 — д',
            'orderDate'             => '19.08.2013',
            //'disc_name'               => 'Алгоритмізація і програмування',    //will added in model
            'knowledge_kind'        => 'Some kind of knowledge',    //will added in model
            'training_direction'    => 'Автоматика та управління',  //will added in model
            'specialization'        => 'Автоматизація та комп\'ютерно-інтегровані технології',  //will added in model
            'trainingForm'          => 'Some form of training', //will added in model
            'faculty'               => 'Some faculty',  //will added in model
            'cathedra'              => 'автоматизації та комп’ютерно-інтегрованих технологій',  //will added in model
            'redactor'              => 'Some redactor', //will added in model
            'reviewers'             => 'Some reviewers',    //will added in model
            'ed_qualification'      => 'Some qualification',    //will added in model
            'opp_code'              => '0000',  //will added in model
            'developer'             => 'Л.І. Гладка', //will added in model
            'ectsCredits'           => '12',
            'modules'               => '4',
            'contextModules'        => '4',
            'hours'                 => '432',
            'weekHours'             => '12',
            'qualificationLevel'    => 'бакалавр',
            'trainingYears'         => '1',
            'semesters'             => '1,2',
            'lectionHours'          => '32',
            'seminaryHours'         => '24',
            'laboratoryHours'       => '108',
            'selfHours'             => '136',
            'individualHours'       => '132',
            'controlTest'           => 'екзамен',
            'tpl_lection_themes'    => 'ТЕМИ ЛЕКЦІЙНИХ ЗАНЯТЬ',
            'tpl_practical_themes'  => 'ТЕМИ ПРАКТИЧНИХ ЗАНЯТЬ',
            'tpl_seminary_themes'   => 'ТЕМИ СЕМІНАРСЬКИХ ЗАНЯТЬ',
            'tpl_laboratory_themes' => 'ТЕМИ ЛАБОРАТОРНИХ ЗАНЯТЬ',
            'tpl_individual_themes' => 'ТЕМИ ІНДИВІДУАЛЬНИХ ЗАНЯТЬ',
            'tpl_self_themes'       => 'ТЕМИ САМОСТІЙНИХ ЗАНЯТЬ',
            'tpl_lection'           => 'Лекційне',
            'tpl_practical'         => 'Практичне',
            'tpl_seminary'          => 'Семінарське',
            'tpl_laboratory'        => 'Лабораторне',
            'tpl_individual'        => 'Індивідуальне',
            'tpl_self'              => 'Самостійне',
        );
    }

    public function getHint($name)
    {
        return $this->hints[$name];
    }

    /**
     * Returns http or https, depends on used protocol.
     *
     * @return string
     */
    public function getProtocol()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
        return $protocol;
    }

    /**
     * Returns domain name.
     *
     * @return string
     * @throws Exception
     */
    public function getBaseUrl()
    {
        return $_SERVER['HTTP_HOST'];
    }

}

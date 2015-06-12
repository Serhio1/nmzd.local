<?php

namespace Src\Views\Themes\Bootstrap;

use App\Core\Container;

class ThemeSettings
{
    private $settings;

    public function init()
    {
        $this->settings = Container::get('params')->getThemeData();
    }

    public function getSettings()
    {
        $themeData = Container::get('params')->getThemeData();

        $themeData['items']['block1']['main_menu'] = array(
            'view' => '/Src/Views/Themes/Bootstrap/Components/navbar_top_black.html.twig',
            'vars' => array(
                'list' => Container::get('Main/MenuModel')->getMenu('main_menu'),
            )
        );

        $themeData['items']['block4']['footer'] = array(
            'view' => '/Src/Views/Themes/Bootstrap/Components/footer_gray.html.twig',
            'vars' => array(
                'copyright' => 'ЧНУ ім.Богдана Хмельницького, 2014р.',
            )
        );

        $themeData['css'][] = '/Src/Views/Themes/Bootstrap/css/bootstrap.min.css';
        $themeData['css'][] = '/Src/Views/Themes/Bootstrap/css/main.css';
        
        $themeData['jsTop']['jQuery'] = '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.min.js';
        $themeData['jsTop']['bootstrap'] = '/Src/Views/Themes/Bootstrap/js/bootstrap.min.js';
        
        return $themeData;
    }
}
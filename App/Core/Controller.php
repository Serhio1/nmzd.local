<?php

namespace App\Core;

use Src\Views\Themes\Test\ThemeSettings;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    protected $errors = '';
    protected $hints = array();

    /**
     * Renders twig template.
     *
     * @param $view
     * @param array $data
     * @return Response
     * @throws \Exception
     */
    public function renderTwig($view, $data=array())
    {
        $twig = Container::get('twig');
        $data = array_merge($data, $this->processView());
        return new Response($twig->render($view, $data));
    }

    /**
     * Renders custom string.
     *
     * @param string $str
     * @return Response
     */
    public function renderString($str = '')
    {
        return new Response($str);
    }
    
    protected function redirect($url, $data=array())
    {
        Container::get('router')->redirect($url, $data);
    }
    
    protected function storage()
    {
        return Container::get('session_storage');
    }

    protected function preProcessView(){}

    protected function processView()
    {
        $this->preProcessView();
        $themeSettings = Container::get('theme_settings');

        $globalTemplateData = array(
            'errors' => $this->errors,
        );

        $globalTemplateData = array_merge_recursive(
            $globalTemplateData,
            $themeSettings
        );

        //dynamic template data, wich uses in all templates (many templates)
        //menu data, sidebar data, etc

        return $globalTemplateData;
    }

    protected function getFormData($form)
    {
        return Container::get('form_mngr')->getFormData($form);
    }

    protected function outErrors()
    {
        return Container::get('errors')->outErrors();
    }

    protected function getForm($form)
    {
        return Container::get('form_mngr')->getForm($form);
    }

    protected function params()
    {
        return Container::get('params');
    }
}

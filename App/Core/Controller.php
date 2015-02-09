<?php

namespace App\Core;

use App\Core\IForm;
use Symfony\Component\HttpFoundation\Response;
use \PFBC\Form;
use \PFBC\View;

abstract class Controller
{
    protected $errors = '';

    protected $hints = array();

    protected function render($data = array())
    {
        return $this->renderTwig('/Src/Views/layout.html.twig', $data);
    }
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

    protected function outErrors()
    {
        return Container::get('errors')->outErrors();
    }

    /**
     * Helper for using forms in controllers.
     *
     * @param $form - form object
     * @param array $config - configuration for form
     * @param $request - HttpFoundation Request object
     * @param $block - string with name of block
     * @throws \Exception
     */
    protected function useForm($form, $config, $request, $block)
    {
        $formName = $form->getFormName();
        $formRequest = $request->request->get($formName);
        if (!empty($formRequest) && $formRequest == $formName) {
            if (Form::isValid($formName)) {

                if ($form->validate($request)) {
                    $form->submit($request);
                }
            }
        }
        $formInstance = $form->build($request, $config);

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    $block => array(
                        $formName => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/std_form.html.twig',
                            'vars' => array(
                                'form' => $formInstance->render(true),
                            )
                        )
                    )
                )
            )
        );
    }

    protected function params()
    {
        return Container::get('params');
    }
}

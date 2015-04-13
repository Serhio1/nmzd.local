<?php

namespace Src\Modules\Admin\Forms;

use App\Core\BaseForm;
use \PFBC\Element;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use App\Core\FileProcessor;

class CacheForm extends BaseForm
{
    protected $formName = 'cache';

    protected $steps = array(
        'formProcess',
    );

    protected function formProcess($form, $request, $config)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->query->get('clear_cache')) {
                FileProcessor::clearDir(Container::get('params')->getCacheDir());
                return;
            }
        }
        $cacheConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'cache.json');
        $cacheConf = json_decode($cacheConfJson);

        $form->configure($config);

        $form->addElement(new Element\HTML('<legend>Управління кешем</legend>'));
        $form->addElement(new Element\Hidden($this->formName, $this->formName));

        $options = array();
        $hidden = array();
        $states = array();
        
        foreach ($cacheConf as $name => $state) {
            $options[$name] = $name;
            if ($state) {
                $states[$name] = $name;
            }
        }
        $form->addElement(new Element\Button("Знищити кеш", "button", array(
            "onclick" => "$.ajax({
                url: '',
                context: document.body,
                data: {\"clear_cache\":true},
                success: function(){
                  alert('done');
                }
            });"
        )));
        $form->addElement(new Element\Checkbox("", "cache", $options, array(
            "value" => $states,
            "class" => $hidden
        )));
        
        $form->addElement(new Element\Button("Зберегти"));
        $form->addElement(new Element\Button("Відмінити", "button", array(
            "onclick" => "history.go(-1);"
        )));

        return $form;
    }

    public function validate(Request $request)
    {
        return true;
    }

    public function submit(Request $request)
    {
        $enableCache = $request->request->get('cache');
        $cacheConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'cache.json');
        $cacheConf = json_decode($cacheConfJson, true);
        $cacheConf = array_fill_keys(array_keys($cacheConf), false);

        if (!is_array($enableCache) && !empty($enableCache['enable_cache'])) {
            $cacheConf['enable_cache'] = false;
        } else {
            $cacheConf['enable_cache'] = true;
        }
        
        
        file_put_contents(Container::get('params')->getConfigDir() . '/' . 'cache.json', json_encode($cacheConf, JSON_UNESCAPED_UNICODE));
        Container::get('router')->redirect('/admin');
    }


    public function getFormName()
    {
        return $this->formName;
    }

    public function setFormName($name)
    {
        $this->formName = $name;
    }
}

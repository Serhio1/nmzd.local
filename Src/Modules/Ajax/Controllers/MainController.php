<?php

/**
 * Main controller for Ajax module
 */

namespace Src\Modules\Ajax\Controllers;

use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Controller;
use App\Core\Router;

class MainController extends Controller
{

    public function indexAction($request)
    {
        require_once 'Src/Modules/Ajax/Libs/PhpLiveX/PHPLiveX.php';
        $ajax = new \PHPLiveX();
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
            'aje' => '/Src/Views/Themes/Bootstrap/js/aje.js',
        );
        $data = array();
        $data['script'] = new Response("$(`.ajecontainer`).aje().setData({`msg`:`ololo`,`block`:`block2`,`component`:`aje_test`}).setMenu(`.testMenu`);");
        
        $collectedComponent = array(
            
            'top_menu' => array(
                'view' => '/Src/Views/Themes/Bootstrap/Components/horizontal_pills.html.twig',
                'vars' => array(
                    'list' => array(
                        'children' => array(
                            array(
                                'title' => 'Створити',
                                'url' => Router::buildUrl('/discipline/create'),
                            )
                        ),
                    ),
                ),
            ),
            
            'aje_test' => array(
                'view' => '/Src/Views/Themes/Bootstrap/Components/ajax.html.twig',
                'vars' => array(
                    'url' => Router::buildUrl('/ajax/test'),
                    'script' => $data['script'],
                )
            ),
        );
        //$collectedComponent['rules']['ajemenu'] = array('topMenu'=>'aje_test');
        
        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => $collectedComponent
                ),
            )
        );
        
        return $this->render($data);
        //require_once 'Src/Modules/Ajax/Controllers/MainController.php';
        /*$myClass = new $this;
        $ajax->AjaxifyObjectMethods(array('myClass' => array('ajaxTest')));*/
        
        //return new Response(Container::get('twigStr')->render('test {{ form_text("fname", "fname", "", "chosen") }}'));
        
        return new Response(Container::get('twigStr')->render('<html><head><meta charset="utf-8" /><script type="text/javascript" src="http://nmzd.local/Src/Modules/Ajax/Libs/PhpLiveX/phplivex.js"></script></head><body>
            This is Ajax index action.
            {{ form_text("fname", "fname", "", "chosen") }}
<input type="button" value="Validate Email" onclick="validate();">  
<input type="text" id="email" size="15" maxlength="15">  
<span id="pr" style="visibility:hidden;"><i>Validating...</i></span>  
<span id="msg"></span> 
<script type="text/javascript">  
function validate(){  
    val = document.getElementById("email").value;  
    myClass.validateEmail(val, {  
        "preloader":"pr",  
        "onFinish": function(response){  
            var msg = document.getElementById("msg");  
            if(response) msg.innerHTML = "Valid Email Address!";  
            else msg.innerHTML = "Invalid Email Address!";  
        }  
    });  
}  
</script>
</body></html>'));
    }
    
    public function testAction()
    {
        return new Response('test');
    }
    
}
<?php

/**
 * Main controller for Devel module
 */

namespace Src\Modules\Devel\Controllers;

use App\Core\Container;
use App\Core\Controller;
use Src\Modules\Devel\Forms\GenModuleForm;
use \PFBC\Form;
use \PFBC\View;

class MainController extends Controller
{
    private $notifications = array();

    public function genModuleAction($request)
    {
        $genForm = new GenModuleForm();

        if (Form::isValid('gen-module')) {
            $moduleName = $request->request->get('module_name', '');
            if (!empty($moduleName)) {
                $basePath = Container::get('params')->getBasePath();
                $moduleName = str_replace(' ', '', $moduleName);
                $oldmask = umask(0);
                mkdir($basePath . '/Src/Modules/' . ucfirst($moduleName), 0777);
                mkdir($basePath . '/Src/Modules/' . ucfirst($moduleName) . '/Controllers', 0777);
                mkdir($basePath . '/Src/Modules/' . ucfirst($moduleName) . '/Models', 0777);
                mkdir($basePath . '/Src/Modules/' . ucfirst($moduleName) . '/Views', 0777);
                mkdir($basePath . '/Src/Modules/' . ucfirst($moduleName) . '/Forms', 0777);

                $fp = fopen($basePath . '/Src/Modules/' . ucfirst($moduleName) . "/Router.php","wb");
                fwrite($fp,$this->getRouterContent($moduleName));
                fclose($fp);

                $fp = fopen($basePath . '/Src/Modules/' . ucfirst($moduleName) . "/Controllers/MainController.php","wb");
                fwrite($fp,$this->getControllerContent($moduleName));
                fclose($fp);

                umask($oldmask);
                $this->notifications[] = 'Your module has been created. You can enable it by adding \'' . $moduleName . '\' => \'Src/Modules/' . ucfirst($moduleName) . '\' to $modules property in class App/Routes. To test your module go to nmkd-dev.local/' . $moduleName . '/test';

            }
        }

        $themeSettings = Container::get('theme_settings');
        $themeSettings['items']['block2'][] = '/Src/Modules/Devel/Views/Templates/gen_module.html.twig';


        return $this->renderTwig(
            '/Src/Views/layout.html.twig',
            array(
                'gen_form' => $genForm->build(array(
                    'action' => '/devel/gen-module',
                ))->render(true),
                'notifications' => $this->notifications,
            ),
            $themeSettings
        );
    }

    private function getRouterContent($moduleName)
    {
        $moduleName = ucfirst($moduleName);
        return '<?php

/**
 * Defines routes for ' . $moduleName . ' module.
 */

namespace Src\Modules\\' . $moduleName . ';

use App\Core\BaseRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router extends BaseRouter
{
    /**
     * Defines array of routes for this module.
     *
     * To define route you need to add array element to result array.
     * Element must contain this structure:
     * id => array(
     *     \'uri\' => \'/address/to/needle\',
     *     \'settings\' => array(
     *         \'_controller\' => Closure
     *     ),
     * ),
     *
     * Read more in HttpKernel documentation
     * @see Symfony\Component\Routing\RouteCollection
     * @see Symfony\Component\Routing\Route
     *
     * @return array
     */
    public function init()
    {
        return array(
            \'index\' => array(
                \'uri\' => \'/test\',
                \'settings\' => array(
                    \'_controller\' => function (Request $request) {
                        return $this->setAction(
                            \'Src/Modules/' . $moduleName . '/Controllers/MainController\',
                            \'index\',
                            $request
                        );
                    }
                )
            ),
        );
    }
}
';
    }

    private function getControllerContent($moduleName)
    {
        $moduleName = ucfirst($moduleName);
        return '<?php

namespace Src\Modules\\' . $moduleName . '\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Controller;
use App\Core\Container;

class MainController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->renderString(\'This is ' . $moduleName . ' start page.\');
    }
}
';
    }
}
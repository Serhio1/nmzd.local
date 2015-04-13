<?php

namespace Src\Modules\Nmkd\Controllers;

use App\Core\Controller;
use Symfony\Component\HttpFoundation\Request;

class NmkdController extends Controller
{
    protected $entity = 'Nmkd/DisciplineModel';

    protected $entityUrl = '/nmkd/discipline/menu';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\NmkdForm';

    protected $block = 'block3';

    public function createAction(Request $request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new $this->form('create'), $formConf, $request, $this->block);

        
        return $this->render();
    }
    
     public function editAction(Request $request)
    {
        $formConf = array('action' => $this->entityUrl);
        $this->useForm(new $this->form('update'), $formConf, $request, $this->block);

        
        return $this->render();
    }

}


<?php

namespace Src\Modules\Nmkd\Controllers;

use Src\Modules\Entity\Controllers\EntityController;

class DisciplineController extends EntityController
{

    protected $entity = 'Nmkd/DisciplineModel';

    protected $entityUrl = '/nmkd/discipline';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\DisciplineForm';

    protected $block = 'block3';

}
<?php

namespace Src\Modules\Nmkd\Controllers;

use Src\Modules\Entity\Controllers\EntityController;

class LabController extends EntityController
{

    protected $entity = 'Nmkd/LabModel';

    protected $entityUrl = '/nmkd/lab';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\LabForm';

    protected $block = 'block3';

}
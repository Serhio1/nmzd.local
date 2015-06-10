<?php

namespace Src\Modules\Nmkd\Controllers;

use Src\Modules\Entity\Controllers\EntityController;

class TypesController extends EntityController
{
    protected $entity = 'Nmkd/TypesModel';

    protected $entityUrl = '/nmkd/types';

    protected $form = '\\Src\\Modules\\Nmkd\\Forms\\TypesForm';

    protected $block = 'block3';
}


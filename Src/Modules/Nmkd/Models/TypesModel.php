<?php

namespace Src\Modules\Nmkd\Models;

use Src\Modules\Entity\Models\EntityModel;

class TypesModel extends EntityModel
{

    protected $table = 'types';

    protected $fields = array(
        'id',
        'title'
    );

}
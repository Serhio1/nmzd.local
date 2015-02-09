<?php

namespace Src\Modules\Nmkd\Models;

use Src\Modules\Entity\Models\EntityModel;

class DisciplineModel extends EntityModel
{

    protected $table = 'discipline';

    protected $fields = array(
        'semester',
        'title',
        'id_speciality',
        'id_subspeciality',
    );

}
<?php

namespace Src\Modules\Nmkd\Models;

use Src\Modules\Entity\Models\EntityModel;

class LabModel extends EntityModel
{

    protected $table = 'laboratory_structure';

    protected $fields = array(
        'discipline_id',
        'theme',
        'id_type',
        'purpose',
        'theory',
        'execution_order',
        'content_structure',
        'requirements',
        'individual_variants',
        'literature'
    );

    protected $parent = 'discipline';
}
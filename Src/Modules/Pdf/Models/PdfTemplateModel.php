<?php

namespace Src\Modules\Pdf\Models;

use Src\Modules\Entity\Models\EntityModel;

class PdfTemplateModel extends EntityModel
{

    protected $table = 'pdf_template';

    protected $fields = array(
        'title',
        'body',
    );
}


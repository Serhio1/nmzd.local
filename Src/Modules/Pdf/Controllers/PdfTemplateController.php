<?php

namespace Src\Modules\Pdf\Controllers;

use Src\Modules\Entity\Controllers\EntityController;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;

class PdfTemplateController extends EntityController
{
    protected $entity = 'Pdf/PdfTemplateModel';

    protected $entityUrl = '/pdf/template';

    protected $form = '\\Src\\Modules\\Pdf\\Forms\\PdfTemplateForm';

    protected $block = 'block3';
}


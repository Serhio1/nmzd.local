<?php

namespace Src\Modules\Pdf\Models;

use Src\Modules\Entity\Models\EntityModel;

class PdfModel extends EntityModel
{

    protected $table = 'pdf_config';

    protected $fields = array(
        'title',
        'page_type',
        'font_size',
        'font_style',
        'margin_top',
        'margin_bottom',
        'margin_left',
        'margin_right',
        'margin_header',
        'margin_footer',
        'header',
        'footer',
        'watermark_text',
        'watermark_opacity',
        'doc_title',
        'doc_author',
        'doc_subject',
        'doc_creator',
        'password',
        'stylesheets',
        'save_option'
    );
}


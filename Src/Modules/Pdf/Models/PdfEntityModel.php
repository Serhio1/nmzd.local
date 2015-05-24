<?php

namespace Src\Modules\Pdf\Models;

use Src\Modules\Entity\Models\EntityModel;
use App\Core\Container;

class PdfEntityModel extends EntityModel
{

    protected $table = 'pdf_entity';

    protected $fields = array(
        'template_id',
        'config_id',
        'key',
        'title',
    );
    
    public function outPdf($key, $vars)
    {
        $entity = $this->selectEntity(array('key'=>$key));
        $tplModel = Container::get('Pdf/PdfTemplateModel');
        $tpl = $tplModel->selectEntity(array('id'=>$entity[0]['template_id']));
        $configModel = Container::get('Pdf/PdfConfigModel');
        $config = $configModel->selectEntity(array('id'=>$entity[0]['config_id']));
        return $this->generate(Container::get('twigStr')->render($tpl[0]['body'], $vars), $config[0]);
    }
    
    public function outPdfRaw($key, $vars)
    {
        $entity = $this->selectEntity(array('key'=>$key));
        $tplModel = Container::get('Pdf/PdfTemplateModel');
        $tpl = $tplModel->selectEntity(array('id'=>$entity[0]['template_id']));
        $configModel = Container::get('Pdf/PdfConfigModel');
        $config = $configModel->selectEntity(array('id'=>$entity[0]['config_id']));
        return Container::get('twigStr')->render($tpl[0]['body'], $vars);
    }
    
    public function outEditedPdf($tpl, $key, $vars)
    {
        $entity = $this->selectEntity(array('key'=>$key));
        $configModel = Container::get('Pdf/PdfConfigModel');
        $config = $configModel->selectEntity(array('id'=>$entity[0]['config_id']));
        return $this->generate(Container::get('twigStr')->render($tpl, $vars), $config[0]);
    }
    
    /**
    * Generate the PDF file using the mPDF library.
    *
    * @param string $html
    *   contents of the template already with the node data.
    * @param string $filename
    *   name of the PDF file to be generated.
    */
    public function generate($html, $config, $filename = 'newPdfDocument')
    {
        // International Paper Sizes ( width x height).
        $paper_size = array(
          '4A0' => array('w' => 1682, 'h' => 2378),
          '2A0' => array('w' => 1189, 'h' => 1682),
          'A0' => array('w' => 841, 'h' => 1189),
          'A1' => array('w' => 594, 'h' => 841),
          'A2' => array('w' => 420, 'h' => 594),
          'A3' => array('w' => 297, 'h' => 420),
          'A4' => array('w' => 210, 'h' => 297),
          'A5' => array('w' => 148, 'h' => 210),
          'A6' => array('w' => 105, 'h' => 148),
          'A7' => array('w' => 74, 'h' => 105),
          'A8' => array('w' => 52, 'h' => 74),
          'A9' => array('w' => 37, 'h' => 52),
          'A10' => array('w' => 26, 'h' => 37),

          'B0' => array('w' => 1000, 'h' => 1414),
          'B1' => array('w' => 707, 'h' => 1000),
          'B2' => array('w' => 500, 'h' => 707),
          'B3' => array('w' => 353, 'h' => 500),
          'B4' => array('w' => 250, 'h' => 353),
          'B5' => array('w' => 176, 'h' => 250),
          'B6' => array('w' => 125, 'h' => 176),
          'B7' => array('w' => 88, 'h' => 125),
          'B8' => array('w' => 62, 'h' => 88),
          'B9' => array('w' => 44, 'h' => 62),
          'B10' => array('w' => 31, 'h' => 44),

          'C0' => array('w' => 917, 'h' => 1297),
          'C1' => array('w' => 648, 'h' => 917),
          'C2' => array('w' => 458, 'h' => 648),
          'C3' => array('w' => 324, 'h' => 458),
          'C4' => array('w' => 229, 'h' => 324),
          'C5' => array('w' => 162, 'h' => 229),
          'C6' => array('w' => 114, 'h' => 162),
          'C7' => array('w' => 81, 'h' => 114),
          'C8' => array('w' => 57, 'h' => 81),
          'C9' => array('w' => 40, 'h' => 57),
          'C10' => array('w' => 28, 'h' => 40),

          'RA0' => array('w' => 860, 'h' => 1220),
          'RA1' => array('w' => 610, 'h' => 860),
          'RA2' => array('w' => 430, 'h' => 610),
          'SRA0' => array('w' => 900, 'h' => 1280),
          'SRA1' => array('w' => 640, 'h' => 900),
          'SRA2' => array('w' => 450, 'h' => 640),

          'Letter' => array('w' => 215.9, 'h' => 279.4),
          'Legal' => array('w' => 215.9, 'h' => 355.6),
          'Ledger' => array('w' => 279.4, 'h' => 431.8),
        );

        $page = $config['page_type']; //conf
        $font_size = $config['font_size'];
        $font_style = $config['font_style'];

        // DEFAULT PDF margin Values.
        $margin_top = $config['margin_top']; //conf
        $margin_right = $config['margin_right'];
        $margin_bottom = $config['margin_bottom'];
        $margin_left = $config['margin_left'];
        $margin_header = $config['margin_header'];
        $margin_footer = $config['margin_footer'];

        // Creating Instance of mPDF Class Library.
        require_once 'Src/Modules/Pdf/Libs/mpdf60/mpdf.php';
        $mpdf = new \mPDF(
          '',
          array($paper_size[$page]['w'], $paper_size[$page]['h']),
          $font_size,
          $font_style,
          $margin_left,
          $margin_right,
          $margin_top,
          $margin_bottom,
          $margin_header,
          $margin_footer
        );

        // set document DPI
        $mpdf->dpi = 96;

        // Set image DPI
        $mpdf->img_dpi = 96;

        // Enabling header option if available.
        $header = $config['header']; //string in conf
        if (isset($header) && $header != NULL) {
          //$header = token_replace($header);
          $mpdf->SetHTMLHeader($header);
        }

        // Enabling Footer option if available.
        $footer = $config['footer'];
        if (isset($footer) && $footer != NULL) {
          //$footer = token_replace($footer);
          $mpdf->SetHTMLFooter($footer);
        }

        // Setting Watermark Text to PDF.
        $watermark_option = 'text'; //conf
        $watermark_opacity = $config['watermark_opacity'];

        // For watermark Text.
        if ($watermark_option == 'text') {
          $text = $config['watermark_text'];
          if (isset($text) && $text != NULL) {
            $mpdf->SetWatermarkText($text, $watermark_opacity);
            $mpdf->showWatermarkText = TRUE;
          }
        }

        // Setting Title to PDF.
        $title = $config['doc_title'];
        if (isset($title) && $title != NULL) {
          $mpdf->SetTitle($title);
        }

        // Setting Author to PDF.
        $author = $config['doc_author']; //conf
        if (isset($author) && $author != NULL) {
          $mpdf->SetAuthor($author);
        }

        // Setting Subject to PDF.
        $subject = $config['doc_subject'];
        if (isset($subject) && $subject != NULL) {
          $mpdf->SetSubject($subject);
        }

        // Setting creator to PDF.
        $creator = $config['doc_creator'];
        if (isset($creator) && $creator != NULL) {
          $mpdf->SetCreator($creator);
        }

        // Setting Password to PDF.
        $password = $config['password'];
        if (isset($password) && $password != NULL) {
          // Print and Copy is allowed.
          $mpdf->SetProtection(array('print', 'copy'), $password, $password);
        }

        // Setting CSS stylesheet to PDF.
        if (!empty($config['stylesheets'])) {
            $cssArr = explode('<br />', nl2br($config['stylesheets']));
            $cssArr = array_map('trim',$cssArr);
            $cssArr = array_filter($cssArr);
            foreach ($cssArr as $key => $stylesheet) {
                $stylesheet_content = NULL;
                if (isset($stylesheet) && $stylesheet != NULL) {
                    $stylesheet_content = file_get_contents($stylesheet);
                    $mpdf->WriteHTML($stylesheet_content, 1);
                }
            }
        }

        // Writing html content for pdf buffer.
        $mpdf->WriteHTML($html);

        return $mpdf->Output($filename . '.pdf', $config['save_option']);
    }
}


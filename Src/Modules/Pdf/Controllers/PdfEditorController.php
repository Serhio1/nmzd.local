<?php

namespace Src\Modules\Pdf\Controllers;

use App\Core\Controller;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PdfEditorController extends Controller
{
    public function pdfEditorAction(Request $request)
    {
        if ($request->query->has('entity') &&
            $request->query->has('option') &&
            $request->query->has('pdf')) {
            
            if (Container::registered($request->query->get('entity'))) {
                $entity = Container::get($request->query->get('entity'));
            }
            $pdfVarsMethod = 'Pdf' . ucfirst($request->query->get('option'));
            $pdf = $request->query->get('pdf');
            $pdfVars = $entity->$pdfVarsMethod($request);
            if ($request->request->has('body')) {
                return Container::get('Pdf/PdfEntityModel')->outEditedPdf($request->request->get('body'), $pdf, $pdfVars);
            }
            $formConf = array('action' => '/pdf/editor');
            $pdf = Container::get('Pdf/PdfEntityModel')->outPdfRaw($pdf, $pdfVars);
            $request->request->set('pdf', $pdf);
            
            $jsTop = array(
                'jQuery' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/jquery-1.7.1.min.js',
                'jsPdfDbg' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/jspdf.debug.js',
                'jsPdfRequire' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/require.js',
                'jsPdfConfig' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/config.js',
                'jsPdf' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/basic.js',
                'jsPdfPng' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/png_support/png.js',
                'jsPdfZlib' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/png_support/zlib.js',
                'jsPdfCssColors' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/css_colors.js',
                'jsPdfCssFonts' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/standard_fonts_metrics.js',
                'jsPdfSplitTextToSize' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/split_text_to_size.js',
                'jsPdfCanvas' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/canvas.js',
                'jsPdfHtml2Canvas' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/html2canvas.js',
                'jsPdfAddImage' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/addimage.js',
                'jsPdfPngSupport' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/png_support.js',
                'jsPdfAnnotations' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/annotations.js',
                'jsPdfContext2d' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/context2d.js',
                'html2pdf' => '/Src/Modules/Pdf/Forms/Elements/PdfCKEditor/js/html2pdf.js',
            );
        

            Container::get('params')->setThemeData(array('jsTop' => $jsTop));
            $this->useForm(new \Src\Modules\Pdf\Forms\PdfEditor('create'), $formConf, $request, 'block3');
            return $this->render();
            //$pdf = Container::get('Pdf/PdfEntityModel')->outPdfRaw($pdf, $pdfVars);
            //return $this->renderTwig('/Src/Modules/Pdf/Views/editor.html.twig', array('pdf'=>$pdf));
        } else {
            return new Response('Error');
        }
    }
}

<?php

class Pdf
{
    //property which contains template names
    private $templates = array();

    //property contains html code
    private $content = array();

    //object of mPdf library
    private $mPdf;

    //set mPdf object to property
    public function getMPDF($mPdf)
    {
        $this->mPdf = $mPdf;
    }

    //iterates templates, "renders" them in buffer
    private function get_include_contents($params) {
        ob_start();                                                     //enable bufferization
        $twig = Container::get('twig');                                 //getting twig object
        $this->addTemplate('pdfTemplates/header.html.twig', $params);   //render header (<html><head><body>)

        
        foreach ($this->templates as $template) {                       //iterates all templates
            if($template != '') {                                       //if template exists
                echo $twig->render($template, $params);                 //render it
            }
        }

        $this->addTemplate('pdfTemplates/footer.html.twig', $params);   //render footer (</body></html>)

        $contents = ob_get_contents();                                  //get content from buffer
        ob_end_clean();                                                 //disable bufferization
        return $contents;
    }

    private function addTemplate($tpl, $params)
    {
        $twig = Container::get('twig');
        echo $twig->render($tpl, $params);
    }

    //iterates content strings, render it in buffer
    private function getContents($params)
    {
        ob_start();                                                     //enable bufferization
        $twig = Container::get('twigStr');                              //getting twig object, string mode

        $this->addTemplate('pdfTemplates/header.html.twig', $params);   //render header (<html><head><body>)
        
        foreach ($this->content as $str) {                              //iterates all strings in content
            if($str != '') {                                            //if string exists
                echo $twig->render($str, $params);                      //render it
            }
        }

        $this->addTemplate('pdfTemplates/footer.html.twig', $params);   //render footer (</body></html>)

        $contents = ob_get_contents();                                  //get content from buffer
        ob_end_clean();                                                 //disable bufferization
        return $contents;
    }
    
    public function downloadPdf($params, $mode='template')
    {
        if ($mode == 'template') {  //get content from templates
            $html=$this->get_include_contents($params);
            $this->mPdf->WriteHTML($html, 0);                           //write content, param '0' means
                                                                        //that css rules are inside template
            $this->mPdf->Output('mpdf.pdf', 'I');                       //enable pdf downloading
            exit;
        } else if ($mode == 'str') {
            $html=$this->getContents($params);
            $this->mPdf->WriteHTML($html);
            
            $this->mPdf->Output();
            exit;
        }
                                                        
                                    
    }

    //added new template to $templates property
    public function addPdfTemplate($template)
    {
        $this->templates[] = $template;
    }

    public function addPdfContent($content)
    {
        $this->content[] = $content;
    }
    
} 

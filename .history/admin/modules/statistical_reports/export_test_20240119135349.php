<?php 
    use Dompdf\Dompdf;

    $pdf = new Dompdf();

    $pdf->getOptions()->setFontDir(_WEB_PATH_ROOT."/includes/vendor/dompdf/dompdf/lib/fonts");
    $pdf->getOptions()->setFontCache(_WEB_PATH_ROOT."/includes/vendor/dompdf/dompdf/lib/fonts");
    $pdf->getOptions()->setIsFontSubsettingEnabled(true);
    $pdf->getOptions()->setDefaultFont('DejaVu Sans');


    $link = getLinkAdmin('reports', 'defect_detail', ['id' => 33, 'action_old'=>'export']);
    $htmlContent = file_get_contents($link);
    // echo $htmlContent;

    $pdf->loadHtml($htmlContent);

    //optional - setup the paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    //render the html as PDF
    $pdf->render();

    //output the generated PDF to Browser
    $pdf->stream('BCCL.'.uniqid().'.pdf', Array('Attachment'=>0));
?>
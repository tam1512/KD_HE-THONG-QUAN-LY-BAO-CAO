<?php 
    use Dompdf\Dompdf;

    $pdf = new Dompdf();

    $link = getLinkAdmin('reports', 'seen', ['id' => 33, 'action_old'=>'export']);
    $htmlContent = file_get_contents($link);

    $pdf->loadHtml($htmlContent);

    //optional - setup the paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    //render the html as PDF
    $pdf->render();

    //output the generated PDF to Browser
    $pdf->stream('BCCL.'.uniqid().'.pdf', Array('Attachment'=>0));
?>
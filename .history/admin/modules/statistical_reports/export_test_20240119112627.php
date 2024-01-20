<?php 
    use Dompdf\Dompdf;

    $pdf = new Dompdf();
    $pdf->loadHtml('hello world');

    //optional - setup the paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    //render the html as PDF
    $pdf->render();

    //output the generated PDF to Browser
    $pdf->stream('BCCL.'.uniqid().'.pdf', Array('Attachment'=>0,'Target' => '_blank'));
?>
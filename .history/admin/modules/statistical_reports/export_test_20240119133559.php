<?php 
    use Dompdf\Dompdf;

    $pdf = new Dompdf();

    $link = getLinkAdmin('reports', 'defect_detail', ['id' => 33, 'action_old'=>'export']);
    $htmlContent = file_get_contents($link);
    echo $htmlContent;

    // $pdf->getOptions()->setDefaultFont('Arial');
    $pdf->loadHtml($htmlContent);
    // $pdf->loadHtml('<p>BIÊN BẢN KIỂM TRA CHẤT LƯỢNG MAY ĐẦU VÀO<p>');
    //optional - setup the paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    //render the html as PDF
    $pdf->render();

    //output the generated PDF to Browser
    $pdf->stream('BCCL.'.uniqid().'.pdf', Array('Attachment'=>0));
?>
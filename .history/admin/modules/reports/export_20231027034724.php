<?php 
   // use Spipu\Html2Pdf\Html2Pdf;
   // use Dompdf\Dompdf;
   $reportId = getBody('get')['id'];
   $action = getBody('get')['action'];

   $link = getLinkAdmin('reports', 'defect_detail', ['id' => $reportId, 'action_old'=>$action]);
   $htmlContent = file_get_contents($link);
   echo $htmlContent;
?>
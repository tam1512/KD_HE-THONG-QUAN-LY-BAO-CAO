<?php 
   $body = getBody('post');
   $reportId = $body['report_id'];

   if(empty($reportId)) {
      echo json_encode(getSession("listAllReportDefectsAdd"));
   } else {
      echo json_encode(getSession("listAllReportDefects[$reportId]"));
  }
?>
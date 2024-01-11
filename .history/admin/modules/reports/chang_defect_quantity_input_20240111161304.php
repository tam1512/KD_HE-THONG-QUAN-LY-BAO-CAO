<?php 
   if(isPost()) {
      $body = getBody("post");
      $key = $body['key'];
      $defect_quantity = $body['defect_quantity'];
      $reportId = $body['report_id'];
      $listAllReportDefect = null;

      if(!empty(getSession("listAllReportDefectsAdd"))) {
         $listAllReportDefect = getSession("listAllReportDefectsAdd");
      } else if(!empty(getSession("listAllReportDefects")))
   }
?>
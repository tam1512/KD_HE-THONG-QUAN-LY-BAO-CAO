<?php 
   if(isPost()) {
      $body = getBody("post");
      $key = $body['key'];
      $defect_quantity = $body['defect_quantity'];
      $reportId = $body['report_id'];
      $listAllReportDefects = null;

      if(empty($reportId)) {
         $listAllReportDefects = getSession("listAllReportDefectsAdd");
      } else {
         $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
      }

      echo json_encode($listAllReportDefects);

      // $listAllReportDefects[$key]['defect_quantity'] = $defect_quantity;

      // if($reportId == 'null') {
      //    setSession("listAllReportDefectsAdd", $listAllReportDefects);
      // } else {
      //    setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
      // }

      // echo json_encode($listAllReportDefects);
   }
?>
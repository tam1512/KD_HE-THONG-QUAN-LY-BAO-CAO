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

      $listAllReportDefects[$key]['defect_quantity'] = $defect_quantity;

      if(empty($reportId)) {
         setSession("listAllReportDefectsAdd", $listAllReportDefects);
      } else {
         setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
      }

      $sumCriticalDefects = 0;
      $sumMajorDefects = 0;
      $sumMinorDefects = 0;

      foreach($listAllReportDefects as $rd) {
         if($rd['level'] == 'Nghiêm trọng') {
            $sumCriticalDefects += intval($rd['defect_quantity']);
         }
         if($rd['level'] == 'Nặng') {
            $sumMajorDefects += intval($rd['defect_quantity']);
         }
         if($rd['level'] == 'Nhẹ') {
            $sumMinorDefects += intval($rd['defect_quantity']);
         }
      }

      $data = [
         "sumCriticalDefects" => $sumCriticalDefects,
         "sumMajorDefects" => $sumMajorDefects,
         "sumMinorDefects" => $sumMinorDefects
      ];

      echo json_encode($data);
   }
?>
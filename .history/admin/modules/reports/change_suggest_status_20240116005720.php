<?php 
   if(isPost()) {
      $body = getBody('post');
      $suggest = $body['suggest'];
      $status = $body['status'];
      $reportId = $body['reportId'];
      echo $body['deductionValue'];
      $dataUpdate = [
         'suggest' => $suggest,
         'status' => $status,
         'update_at' => date("d-m-Y H:i:s")
      ];

      $statusUpdate = update("reports", $dataUpdate, "id = $reportId");
      echo $statusUpdate;
   }
?>
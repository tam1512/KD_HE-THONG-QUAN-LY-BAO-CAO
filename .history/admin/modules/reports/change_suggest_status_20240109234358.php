<?php 
   if(isPost()) {
      $suggest = getBody('post')['suggest'];
      $status = getBody('post')['status'];
      $reportId = getBody('post')['status'];

      $dataUpdate = [
         'suggest' => $suggest,
         'status' => $status,
         'update_at' => date("d-m-Y H:i:s")
      ];

      $statusUpdate = update("reports", $dataUpdate, "id = $reportId");

      echo $statusUpdate;
   }
?>
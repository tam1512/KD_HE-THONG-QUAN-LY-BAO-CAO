<?php 
   if(isPost()) {
      $body = getBody('post');
      $suggest = $body['suggest'];
      $status = $body['status'];
      $reportId = $body['reportId'];
      $deductionValue = $body['deductionValue'];
      $unit = $body['unit'];

      if(!empty($deductionValue)) {
         $deduction = [
            'value' => $deductionValue,
            'unit' => $unit,
         ];
         $dataUpdate = [
            'suggest' => $suggest,
            'status' => $status,
            'update_at' => date("d-m-Y H:i:s")
         ];
      }

      $dataUpdate = [
         'suggest' => $suggest,
         'status' => $status,
         'update_at' => date("d-m-Y H:i:s")
      ];

      $statusUpdate = update("reports", $dataUpdate, "id = $reportId");
      echo $statusUpdate;
   }
?>
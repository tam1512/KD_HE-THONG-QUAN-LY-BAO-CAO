<?php 
   if(isPost()) {
      $body = getBody('post');
      $suggest = $body['suggest'];
      $status = $body['status'];
      $reportId = $body['reportId'];
      $deductionValue = $body['deductionValue'];
      $unit = $body['unit'];

      if($status == "4") {
         $deduction = [
            'value' => $deductionValue,
            'unit' => $unit,
         ];
         $dataUpdate = [
            'suggest' => $suggest,
            'status' => $status,
            'deduction' => json_encode($deduction),
            'update_at' => date("d-m-Y H:i:s")
         ];
      } else {
         $dataUpdate = [
            'suggest' => $suggest,
            'status' => $status,
            'deduction' => "",
            'update_at' => date("d-m-Y H:i:s")
         ];
      }

      $statusUpdate = update("reports", $dataUpdate, "id = $reportId");
      echo $statusUpdate;
   }
?>
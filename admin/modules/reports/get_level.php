<?php 
   if(isPost()) {
      $defectId = getBody('post')['defectId'];
      if(!empty($defectId)) {
         $defect = firstRaw("SELECT level FROM defects WHERE id = $defectId");
         if(!empty($defect)) {
            echo $defect['level'];
         }
      }
   }
?>
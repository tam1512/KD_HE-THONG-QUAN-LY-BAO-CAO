<?php 
   $listAllDefectCates = getRaw("SELECT id, name FROM defect_categories");
   echo json_encode($listAllDefectCates);
?>
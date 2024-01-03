<?php 
   $listAllDefects = getRaw("SELECT id, name FROM defects");
   echo json_encode($listAllDefects);
?>
<?php 
   if(isGet()) {
      $body = getBody('get');
      if(!empty($body['cate_id'])) {
         $cateId = trim($body['cate_id']);

         $listAllDefects = getRaw("SELECT id, name FROM defects WHERE cate_id = $cateId");
      } else {
         // $listAllDefects = getRaw("SELECT id, name FROM defects");
      }
      if(!empty($body['defect_id'])) {
         $defectId = trim($body['defect_id']);

         $cate = firstRaw("SELECT cate_id, (SELECT name FROM defect_categories WHERE id = defects.cate_id) AS cate_name FROM defects WHERE id = $defectId");
      } else if(empty($body['cate_id'])) {
         $cate = getRaw("SELECT id, name FROM defect_categories");
      }
   }

   if(!empty($listAllDefects)) {
      echo json_encode($listAllDefects);
   }

   if(!empty($cate)) {
      echo json_encode($cate);
   }
?>
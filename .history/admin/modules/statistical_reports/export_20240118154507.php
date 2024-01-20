<?php 
   if(isPost()) {
      $body = getBody('post');
      $data = $body['data'];
      if(!empty($data)) {
         $data = json_decode($data, true);
      }
      $excel = new PHPExcel();
   }
?>
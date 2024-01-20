<?php 
   if(isPost()) {
      $body = getBody('post');
      $data = $body['data'];
      $excel = new PHPExcel();
   }
?>
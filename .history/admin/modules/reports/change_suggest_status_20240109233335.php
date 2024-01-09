<?php 
   if(isPost()) {
      $suggest = getBody('post')['suggest'];
      $status = getBody('post')['status'];
   }
?>
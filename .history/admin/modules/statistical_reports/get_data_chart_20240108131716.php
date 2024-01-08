<?php 

if(isPost()) {
   $body = getBody('post');
   echo '<pre>';
   print_r($body);
   echo '</pre>';
}

?>
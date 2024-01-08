<?php 

if(isPost()) {
   $body = getBody('post');
   echo json_encode($body);
}

?>
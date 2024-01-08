<?php 

if(isPost()) {
   $body = getBody('post');
   echo $body['condition'];
}

?>
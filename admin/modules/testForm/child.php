<?php 
   if(!empty(getSession('session_test'))) {
      $arr = getSession('session_test');
      $arr = json_decode($arr, true);
   } else {
      $arr = [1, 2, 3, 4, 5];
   }
   $number = end($arr);
   $number++;
   $arr[] = $number;
   $arr = json_encode($arr);
   echo $arr;
   setSession('session_test', $arr);
?>
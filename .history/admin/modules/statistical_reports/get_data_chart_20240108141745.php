<?php 

if(isPost()) {
   $body = getBody('post');
   $condition = $body["condition"];
   $object = $condition["valueObj"];
   $year = $condition["valueYear"];
   $month = !empty($condition["valueMonth"]) ? $condition["valueMonth"] : false;
   $first = $body["first"];

   $filter = '';
   $sql = "";
   if(!empty($year)) {
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      
      $filter .= " $operator YEAR(create_at) = $year";
   }

   if(!empty($month)) {
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }

      $filter .= " $operator CONCAT(MONTH(create_at), '/', YEAR(create_at)) = '$month/$year'";
   }

   if(!empty($object)) {
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      if($object != 'all') {
         $filter .= " $operator factory_id=$object";   
      } else {
         $sql = "SELECT f.name, SUM(quantity_deliver) AS total_deliver, SUM(quantity_inspect) AS total_inspect, SUM(ra.total_defect) AS total_defect FROM reports AS rp JOIN resultaql AS ra ON rp.id = ra.report_id JOIN factories AS f ON f.id = rp.factory_id $filter GROUP BY factory_id;";
      }
   }

echo $sql;

}

?>
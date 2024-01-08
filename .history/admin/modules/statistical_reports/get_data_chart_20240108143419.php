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
      
      $filter .= " $operator YEAR(rp.create_at) = $year";
   }

   if(!empty($month)) {
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }

      $filter .= " $operator CONCAT(MONTH(rp.create_at), '/', YEAR(rp.create_at)) = '$month/$year'";
   }

   if(!empty($object)) {
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      if($object != 'all') {
         $filter .= " $operator factory_id=$object";   
         $sql = "select df.id, df.name, sum(rd.defect_quantity) as sum_defect 
         from report_defect as rd 
         join reports as rp on rp.id = rd.report_id 
         join defects as df on df.id = rd.defect_id
         join factories as f on rp.factory_id = f.id
         where f.id = 1 AND YEAR(rp.create_at) = 2024
         group by df.name;"
      } else {
         $sql = "SELECT f.name, SUM(quantity_deliver) AS total_deliver, SUM(quantity_inspect) AS total_inspect, SUM(ra.total_defect) AS total_defect FROM reports AS rp JOIN resultaql AS ra ON rp.id = ra.report_id JOIN factories AS f ON f.id = rp.factory_id $filter GROUP BY factory_id;";
      }
   }

echo $sql;

}

?>
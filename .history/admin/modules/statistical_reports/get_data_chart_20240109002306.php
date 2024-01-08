<?php 

if(isPost()) {
   $body = getBody('post');
   $condition = $body["condition"];
   $object = $condition["valueObj"];
   $year = $condition["valueYear"];
   $month = !empty($condition["valueMonth"]) ? $condition["valueMonth"] : false;
   $first = $body["first"];
   $config = "";
   $isAll = false;
   $isAlone = false;

   $filter = '';
   $sql = "";
   if(!empty($year)) {
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      
      $filter .= "$operator YEAR(rp.create_at) = $year";
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
         $isAlone = true;
         $filter .= " $operator f.id=$object";   
         $sql = "SELECT df.id, df.name, SUM(rd.defect_quantity) AS sum_defect 
         FROM report_defect AS rd 
         JOIN reports AS rp ON rp.id = rd.report_id 
         JOIN defects AS df ON df.id = rd.defect_id
         JOIN factories AS f ON rp.factory_id = f.id
         $filter
         GROUP BY df.name;";
      } else {
         $isAll = true;
         $sql = "SELECT f.id, f.name, SUM(quantity_deliver) AS total_deliver, SUM(quantity_inspect) AS total_inspect, SUM(ra.total_defect) AS total_defect 
         FROM reports AS rp 
         JOIN resultaql AS ra ON rp.id = ra.report_id 
         JOIN factories AS f ON f.id = rp.factory_id 
         $filter 
         GROUP BY factory_id;";
      }
   }

$dataChart = getRaw($sql);
if($isAll) {
   $listAllFactories = getRaw("SELECT id, name FROM factories");
   $dataChart["list"] = $listAllFactories;
} else if($isAlone){
   $listAllDefects = getRaw("SELECT id, name FROM defects");
   $dataChart["list"] = $listAllDefects;
}

echo json_encode($dataChart);

}

?>
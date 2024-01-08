<?php 

if(isPost()) {
   $body = getBody('post');
   $condition = $body["condition"];
   $object = $condition["valueObj"];
   $year = $condition["valueYear"];
   $month = !empty($condition["valueMonth"]) ? $condition["valueMonth"] : false;
   $first = $body["first"];
   $config = "";
   $dataRender = "";
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
         $sql = "SELECT df.id, df.name, SUM(rd.defect_quantity) AS total_defect 
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
   $labels = "";
   $dataTotalInspect = "";
   $dataTotalDefect = "";
   $dataPercent = "";

   $listAllFactories = getRaw("SELECT id, name FROM factories");
   //Lấy ra danh sách đủ fac có tổng lỗi nhận, tổng lỗi, phần trăm lỗi, tách ra làm 3 chuỗi dạng []
   foreach($listAllFactories as $key=>$fac) {
      foreach($dataChart as $item) {
         if($fac['id'] == $item['id']) {
            $fac['total_inspect'] = $item['total_inspect'];
            $fac['total_defect'] = $item['total_defect'];
            $fac['percent'] = $item['total_defect'] / $item['total_inspect'] * 100;
            $listAllFactories[$key] = $fac;
            break;
         } else {
            $fac['total_inspect'] = 0;
            $fac['total_defect'] = 0;
            $fac['percent'] = 0;
         }
         $listAllFactories[$key] = $fac;
      }
   }

   foreach($listAllFactories as $item) {
      $labels .= '"'.$item['name'].'", ';
      $dataTotalInspect .= ''.$item['total_inspect'].', ';
      $dataTotalDefect .= ''.$item['total_defect'].', ';
      $dataPercent .= ''.$item['percent'].', ';
   }

   $dataRender = '
   {
      labels: ['.$labels.'],
      datasets: [
        {
          label: "Tổng số lượng kiểm",
          data: ['.$dataTotalInspect.'],
          backgroundColor: ["rgba(255, 26, 104, 0.2)"],
          borderColor: ["rgba(255, 26, 104, 1)"],
          borderWidth: 1,
          type: "bar",
        },
        {
          label: "Tổng số lỗi",
          data: ['.$dataTotalDefect.'],
          backgroundColor: ["rgba(25, 26, 104, 0.2)"],
          borderColor: ["rgba(25, 26, 104, 1)"],
          borderWidth: 1,
          type: "bar",
        },
        {
          label: "Phần trăm lỗi",
          data: ['.$dataPercent.'],
          backgroundColor: ["rgba(255, 0, 0, 0.2)"],
          borderColor: ["rgba(255, 0, 0, 1)"],
          borderWidth: 1,
          yAxisID: "percentage",
        },
      ],
    };
   ';

   $config = '
   {
      type: "line",
      data: '.$dataRender.',
      options: {
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Số lượng lỗi",
            },
          },
          percentage: {
            beginAtZero: true,
            position: "right",
            title: {
              display: true,
              text: "Phần trăm lỗi (%)",
            },
          },
        },
      },
    };
   ';
} else if($isAlone){
   $labels = "";
   $dataTotalDefect = "";
   $listAllDefects = getRaw("SELECT id, name FROM defects");

   foreach($listAllDefects as $key=>$defect) {
      foreach($dataChart as $item) {
         if($defect['id'] == $item['id']) {
            $defect['total_defect'] = $item['total_defect'];
            $listAllDefects[$key] = $defect;
            break;
         } else {
            $defect['total_defect'] = 0;
         }
         $listAllDefects[$key] = $defect;
      }
   }

   foreach($listAllDefects as $item) {
      $labels .= '"'.$item['name'].'", ';
      $dataTotalDefect .= ''.$item['total_defect'].', ';
   }

   $dataRender = '
   {
      labels: ['.$labels.'],
      datasets: [
        {
          label: "Tổng số lượng kiểm",
          data: ['.$dataTotalDefect.'],
          backgroundColor: ["rgba(255, 26, 104, 0.2)"],
          borderColor: ["rgba(255, 26, 104, 1)"],
          borderWidth: 1,
          type: "bar",
        }
      ],
    };
   ';

   $config = '
   {
      type: "line",
      data: '.$dataRender.',
      options: {
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Số lượng lỗi",
            },
          }
        },
      },
    };
   ';
}

$data = '<canvas id="myChart" data-settings='.$config.'></canvas>';

echo $data;
}

?>
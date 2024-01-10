<?php 

/**
 * valueType:
 * 1 => theo tháng -> object (all hay cơ sở) 
 * - all : lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách cơ cở
 * - cơ sở: lỗi nặng, nhẹ, nghiêm trọng, tỉ lệ lỗi và tỉ lệ phần trăm cộng dồn theo danh sách nhóm lỗi
 * 
 * 2 => Theo năm -> object (all hay cơ sở)
 * - all: giống theo tháng
 * - cơ sở: giống theo tháng
 * 
 * 3 => Theo năm (12 tháng) -> object (all hay cơ sở)
 * - all: lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách 12 tháng
 * - cơ sở: lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách 12 tháng
 *  
 * */

if(isPost()) {
   $body = getBody('post');
   $condition = $body["condition"];
   $object = $condition["valueObj"];
   $status = $condition["valueType"];
   $year = $condition["valueYear"];
   $month = !empty($condition["valueMonth"]) ? $condition["valueMonth"] : false;
   $first = $body["first"];
   $config = "";
   $dataRender = "";
   $dataTable = "";
   $isAlone = false;
   $time = "";
   $filter = '';
   $nameFactory = "";
   if(!empty($year)) {
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      
      $filter .= "$operator YEAR(rp.create_at) = $year";
      $time = "năm $year";
   }

   if(!empty($month)) {
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }

      $filter .= " $operator CONCAT(MONTH(rp.create_at), '/', YEAR(rp.create_at)) = '$month/$year'";
      $time = "tháng $month/$year";
   }

   if(!empty($object)) {
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      if($object != 'all') {
         $filter .= " $operator f.id=$object";   
         $sqlFirst = "SELECT dc.id, dc.name, SUM(rd.defect_quantity) AS total_defect 
         FROM report_defect AS rd 
         JOIN reports AS rp ON rp.id = rd.report_id 
         JOIN defects AS df ON df.id = rd.defect_id
         JOIN factories AS f ON rp.factory_id = f.id
         JOIN defect_categories AS dc ON df.cate_id = dc.id
         $filter
         GROUP BY df.cate_id
         ORDER BY total_defect DESC;";

         $sqlTotalSerious = "SELECT df.cate_id, SUM(rd.defect_quantity) 
         FROM report_defect AS rd 
         JOIN reports AS rp ON rp.id = rd.report_id 
         JOIN defects AS df ON df.id = rd.defect_id
         WHERE $filter AND rd.level = 'Nghiêm trọng'
         GROUP BY df.cate_id;";

         $sqlTotalHeavy = "SELECT df.cate_id, SUM(rd.defect_quantity) 
         FROM report_defect AS rd 
         JOIN reports AS rp ON rp.id = rd.report_id 
         JOIN defects AS df ON df.id = rd.defect_id
         WHERE $filter AND rd.level = 'Nặng'
         GROUP BY df.cate_id;";

         $sqlTotalLight = "SELECT df.cate_id, SUM(rd.defect_quantity) 
         FROM report_defect AS rd 
         JOIN reports AS rp ON rp.id = rd.report_id 
         JOIN defects AS df ON df.id = rd.defect_id
         WHERE $filter AND rd.level = 'Nhẹ'
         GROUP BY df.cate_id;";

         $nameFactory = firstRaw("SELECT name FROM factories WHERE id = $object")['name'];


         

      } else {
         //sql lấy tổng số lượng nhận, tổng lỗi kiểm của từng cơ sở
         $sqlFirst = "SELECT f.id, f.name, SUM(quantity_deliver) AS total_deliver, SUM(quantity_inspect) AS total_inspect, SUM(total_defect) AS total_defect
         FROM reports AS rp 
         JOIN factories AS f ON f.id = rp.factory_id 
         $filter 
         GROUP BY factory_id;";

         // sql lấy torng lỗi nhẹ, nặng, nghiêm trọng của từng cơ sở
         $sqlSecond = "SELECT rp.factory_id, SUM(quantity_serious_real) AS total_serious, SUM(quantity_heavy_real) AS total_heavy, SUM(quantity_light_real) AS total_light 
         FROM resultaql AS ra JOIN reports AS rp ON rp.id = ra.report_id 
         $filter
         GROUP BY rp.factory_id;";

         $labels = "";
         $dataTotalInspect = "";
         $dataTotalDefect = "";
         $dataTotalSerious = "";
         $dataTotalHeavy = "";
         $dataTotalLight = "";
         $dataPercentSerious = "";
         $dataPercentHeavy = "";
         $dataPercentLight = "";

         //
         $listAllFactoriesFirst = getRaw($sqlFirst);
         $listAllFactoriesSecond = getRaw($sqlSecond);

         $dataAllFactoties = [];
         if(!empty($listAllFactoriesFirst) && !empty($listAllFactoriesSecond)) {
            foreach($listAllFactoriesFirst as $key => $first) {
                  if($first["id"] == $listAllFactoriesSecond[$key]['factory_id']) {
                     $dataAllFactoties[] = [
                        "id" => $first["id"],
                        "name" => $first["name"],
                        "total_deliver" => $first["total_deliver"],
                        "total_inspect" => $first["total_inspect"],
                        "total_defect" => $first["total_defect"],
                        "total_serious" => $listAllFactoriesSecond[$key]["total_serious"],
                        "total_heavy" => $listAllFactoriesSecond[$key]["total_heavy"],
                        "total_light" => $listAllFactoriesSecond[$key]["total_light"],
                        "percent_serious" => round($listAllFactoriesSecond[$key]["total_serious"] / $first["total_inspect"] * 100, 2),
                        "percent_heavy" => round($listAllFactoriesSecond[$key]["total_heavy"] / $first["total_inspect"] * 100, 2),
                        "percent_light" => round($listAllFactoriesSecond[$key]["total_light"] / $first["total_inspect"] * 100, 2)
                     ];
                  }
            }
         }

         $listAllFactories = getRaw("SELECT id, name FROM factories");

         //Lấy ra danh sách đủ fac có tổng lỗi nhận, tổng lỗi, phần trăm lỗi, tách ra làm 3 chuỗi dạng []
         foreach($listAllFactories as $key=>$fac) {
            if(!empty($dataAllFactoties)) {
               foreach($dataAllFactoties as $item) {
                  if($fac['id'] == $item['id']) {
                     $fac['total_deliver'] = $item['total_deliver'];
                     $fac['total_inspect'] = $item['total_inspect'];
                     $fac['total_defect'] = $item['total_defect'];
                     $fac['total_serious'] = $item['total_serious'];
                     $fac['total_heavy'] = $item['total_heavy'];
                     $fac['total_light'] = $item['total_light'];
                     $fac['percent_serious'] = $item['percent_serious'];
                     $fac['percent_heavy'] = $item['percent_heavy'];
                     $fac['percent_light'] = $item['percent_light'];
                     $listAllFactories[$key] = $fac;
                     break;
                  } else {
                     $fac['total_deliver'] = 0;
                     $fac['total_inspect'] = 0;
                     $fac['total_defect'] = 0;
                     $fac['total_serious'] = 0;
                     $fac['total_heavy'] = 0;
                     $fac['total_light'] = 0;
                     $fac['percent_serious'] = 0;
                     $fac['percent_heavy'] = 0;
                     $fac['percent_light'] = 0;
                  }
                  $listAllFactories[$key] = $fac;
               }
            } else {
               $listAllFactories[$key] = [
                  "id" => $fac["id"],
                  "name" => $fac["name"],
                  'total_deliver' => 0,
                  'total_inspect' => 0,
                  'total_defect' => 0,
                  'total_serious' => 0,
                  'total_heavy' => 0,
                  'total_light' => 0,
                  'percent_serious' => 0,
                  'percent_heavy' => 0,
                  'percent_light' => 0
               ];
            }
         }

         $dataTable = '
         <table class="table table-bordered">
            <tr>
               <th>NCC</th>
               <th>Số lượng giao</th>
               <th>Số lượng kiểm</th>
               <th>Tổng lỗi</th>
               <th>Tổng nghiêm trọng</th>
               <th>Tổng nặng</th>
               <th>Tổng nhẹ</th>
               <th>Tỷ lệ lỗi (%)</th>
            </tr>
         ';

         $contentTable = "";
         foreach($listAllFactories as $item) {
            $labels .= '"'.$item['name'].'", ';
            $dataTotalInspect .= ''.$item['total_inspect'].', ';
            $dataTotalDefect .= ''.$item['total_defect'].', ';
            $dataTotalSerious .= ''.$item['total_serious'].', ';
            $dataTotalHeavy .= ''.$item['total_heavy'].', ';
            $dataTotalLight .= ''.$item['total_light'].', ';
            $dataPercentSerious .= ''.$item['percent_serious'].', ';
            $dataPercentHeavy .= ''.$item['percent_heavy'].', ';
            $dataPercentLight .= ''.$item['percent_light'].', ';

            $contentTable .= '
            <tr>
               <td>'.$item['name'].'</td>
               <td>'.$item['total_deliver'].'</td>
               <td>'.$item['total_inspect'].'</td>
               <td>'.$item['total_defect'].'</td>
               <td>'.$item['total_serious'].'</td>
               <td>'.$item['total_heavy'].'</td>
               <td>'.$item['total_light'].'</td>
               <td>'.$item['percent_serious'].'</td>
               <td>'.$item['percent_heavy'].'</td>
               <td>'.$item['percent_light'].'</td>
            </tr>
            ';
         }

         $dataTable .= $contentTable.'</table>';

         $dataRender = '
         {
            "labels": ['.trim(trim($labels),',').'],
            "datasets": [
            {
               "label": "Tổng số lượng kiểm",
               "data": ['.trim(trim($dataTotalInspect),',').'],
               "backgroundColor": ["rgba(255, 26, 104, 0.2)"],
               "borderColor": ["rgba(255, 26, 104, 1)"],
               "borderWidth": 1,
               "type": "bar",
               "tension": 0.4
            },
            {
               "label": "Tổng lỗi nghiêm trọng",
               "data": ['.trim(trim($dataTotalSerious),',').'],
               "backgroundColor": ["rgba(25, 26, 104, 0.2)"],
               "borderColor": ["rgba(25, 26, 104, 1)"],
               "borderWidth": 1,
               "type": "bar",
               "tension": 0.4
            },
            {
               "label": "Tổng lỗi nặng",
               "data": ['.trim(trim($dataTotalHeavy),',').'],
               "backgroundColor": ["rgba(234, 154, 0, 0.2)"],
               "borderColor": ["rgba(234, 154, 0, 1)"],
               "borderWidth": 1,
               "type": "bar",
               "tension": 0.4
            },
            {
               "label": "Tổng lỗi nhẹ",
               "data": ['.trim(trim($dataTotalLight),',').'],
               "backgroundColor": ["rgba(45, 235, 0, 0.2)"],
               "borderColor": ["rgba(45, 235, 0, 1)"],
               "borderWidth": 1,
               "type": "bar",
               "tension": 0.4
            },
            {
               "label": "Phần trăm lỗi nghiêm trọng",
               "data": ['.trim(trim($dataPercentSerious),',').'],
               "backgroundColor": ["rgba(255, 0, 0, 0.2)"],
               "borderColor": ["rgba(255, 0, 0, 1)"],
               "borderWidth": 1,
               "tension": 0.4,
               "yAxisID": "percentage"
            },
            {
               "label": "Phần trăm lỗi nặng",
               "data": ['.trim(trim($dataPercentHeavy),',').'],
               "backgroundColor": ["rgba(254, 235, 0, 0.2)"],
               "borderColor": ["rgba(254, 235, 0, 1)"],
               "borderWidth": 1,
               "tension": 0.4,
               "yAxisID": "percentage"
            },
            {
               "label": "Phần trăm lỗi nhẹ",
               "data": ['.trim(trim($dataPercentLight),',').'],
               "backgroundColor": ["rgba(92, 251, 0, 0.2)"],
               "borderColor": ["rgba(92, 251, 0, 1)"],
               "borderWidth": 1,
               "tension": 0.4,
               "yAxisID": "percentage"
            }
            ]
         }
         ';

         $config = '
         {
            "type": "line",
            "data": '.$dataRender.',
            "options": {
               "plugins": {
                  "title": {
                     "display": true,
                     "text": "Biểu đồ tỷ lệ lỗi chất lượng may đầu vào '.$time.'"
                  }
               },
            "scales": {
               "y": {
                  "beginAtZero": true,
                  "title": {
                  "display": true,
                  "text": "Số lượng lỗi"
                  }
               },
               "percentage": {
                  "beginAtZero": true,
                  "position": "right",
                  "title": {
                  "display": true,
                  "text": "Phần trăm lỗi (%)"
                  },
                  "grid": {
                     "drawOnChartArea": false
                  }
               }
            }
            }
         }
         ';
      }
   }

$dataChart = getRaw($sqlFirst);
if($isAll) {
   $labels = "";
   $dataTotalInspect = "";
   $dataTotalDefect = "";
   $dataPercent = "";

   $listAllFactories = getRaw("SELECT id, name FROM factories");
   //Lấy ra danh sách đủ fac có tổng lỗi nhận, tổng lỗi, phần trăm lỗi, tách ra làm 3 chuỗi dạng []
   foreach($listAllFactories as $key=>$fac) {
      if(!empty($dataChart)) {
         foreach($dataChart as $item) {
            if($fac['id'] == $item['id']) {
               $fac['total_deliver'] = $item['total_deliver'];
               $fac['total_inspect'] = $item['total_inspect'];
               $fac['total_defect'] = $item['total_defect'];
               $fac['percent'] = round($item['total_defect'] / $item['total_inspect'] * 100, 2);
               $listAllFactories[$key] = $fac;
               break;
            } else {
               $fac['total_deliver'] = 0;
               $fac['total_inspect'] = 0;
               $fac['total_defect'] = 0;
               $fac['percent'] = 0;
            }
            $listAllFactories[$key] = $fac;
         }
      } else {
         $listAllFactories[$key] = [
            "name" => $fac['name'],
            "total_deliver" => 0,
            "total_inspect" => 0,
            "total_defect" => 0,
            "percent" => 0
         ];
      }
   }

   $dataTable = '
   <table class="table table-bordered">
      <tr>
         <th>NCC</th>
         <th>Số lượng giao</th>
         <th>Số lượng kiểm</th>
         <th>Tổng lỗi</th>
         <th>Tỷ lệ lỗi (%)</th>
      </tr>
   ';

   $contentTable = "";
   foreach($listAllFactories as $item) {
      $labels .= '"'.$item['name'].'", ';
      $dataTotalInspect .= ''.$item['total_inspect'].', ';
      $dataTotalDefect .= ''.$item['total_defect'].', ';
      $dataPercent .= ''.$item['percent'].', ';

      $contentTable .= '
      <tr>
         <td>'.$item['name'].'</td>
         <td>'.$item['total_deliver'].'</td>
         <td>'.$item['total_inspect'].'</td>
         <td>'.$item['total_defect'].'</td>
         <td>'.$item['percent'].'</td>
      </tr>
      ';
   }

   $dataTable .= $contentTable.'</table>';

   $dataRender = '
   {
      "labels": ['.trim(trim($labels),',').'],
      "datasets": [
        {
          "label": "Tổng số lượng kiểm",
          "data": ['.trim(trim($dataTotalInspect),',').'],
          "backgroundColor": ["rgba(255, 26, 104, 0.2)"],
          "borderColor": ["rgba(255, 26, 104, 1)"],
          "borderWidth": 1,
          "type": "bar",
          "tension": 0.4
        },
        {
          "label": "Tổng số lỗi",
          "data": ['.trim(trim($dataTotalDefect),',').'],
          "backgroundColor": ["rgba(25, 26, 104, 0.2)"],
          "borderColor": ["rgba(25, 26, 104, 1)"],
          "borderWidth": 1,
          "type": "bar",
          "tension": 0.4
        },
        {
          "label": "Phần trăm lỗi",
          "data": ['.trim(trim($dataPercent),',').'],
          "backgroundColor": ["rgba(255, 0, 0, 0.2)"],
          "borderColor": ["rgba(255, 0, 0, 1)"],
          "borderWidth": 1,
          "tension": 0.4,
          "yAxisID": "percentage"
        }
      ]
    }
   ';

   $config = '
   {
      "type": "line",
      "data": '.$dataRender.',
      "options": {
         "plugins": {
            "title": {
               "display": true,
               "text": "Biểu đồ tỷ lệ lỗi chất lượng may đầu vào '.$time.'"
             }
         },
        "scales": {
          "y": {
            "beginAtZero": true,
            "title": {
              "display": true,
              "text": "Số lượng lỗi"
            }
          },
          "percentage": {
            "beginAtZero": true,
            "position": "right",
            "title": {
              "display": true,
              "text": "Phần trăm lỗi (%)"
            },
            "grid": {
               "drawOnChartArea": false
            }
          }
        }
      }
    }
   ';
} else if($isAlone){
   $labels = "";
   $dataTotalDefect = "";
   $dataPercent = "";

   
   $dataTable = '
   <table class="table table-bordered">
      <tr>
         <th width="10%">STT</th>
         <th width="20%">Tên lỗi</th>
         <th>Tổng số lượng lỗi</th>
         <th>Phần trăm tích lũy (%)</th>
      </tr>
   ';

   $contentTable = "";
   $count = 0;
   $total = 0;
   $prevTotal = 0;
   //add phần trăm tích lũy
   foreach($dataChart as $item) {
      $total += $item['total_defect'];
   }

   foreach($dataChart as $key=>$item) {
      $percent = ($prevTotal + $item['total_defect']) / $total * 100;
      $prevTotal += $item['total_defect'];

      $dataChart[$key]['percent'] = round($percent, 2);
   }

   foreach($dataChart as $item) {
      $count++;
      $labels .= '"'.$item['name'].'", ';
      $dataTotalDefect .= ''.$item['total_defect'].', ';
      $dataPercent .= ''.$item['percent'].', ';
      $contentTable .= '
      <tr>
         <td>'.$count.'</td>
         <td>'.$item['name'].'</td>
         <td>'.$item['total_defect'].'</td>
         <td>'.$item['percent'].'</td>
      </tr>
      ';      
   }

   $dataTable .= $contentTable.'</table>';

   $dataRender = '{
      "labels": ['.trim(trim($labels),',').'],
      "datasets": [
        {
          "label": "Tổng số lượng kiểm",
          "data": ['.trim(trim($dataTotalDefect),',').'],
          "backgroundColor": ["rgba(25, 26, 104, 0.2)"],
          "borderColor": ["rgba(25, 26, 104, 1)"],
          "borderWidth": 1,
          "type": "bar",
          "tension": 0.4
        },
        {
          "label": "Phần trăm tích lũy",
          "data": ['.trim(trim($dataPercent),',').'],
          "backgroundColor": ["rgba(255, 0, 0, 0.2)"],
          "borderColor": ["rgba(255, 0, 0, 1)"],
          "borderWidth": 1,
          "tension": 0.4,
          "yAxisID": "percentage"
        }
      ]
    }
   ';

   $config = '
   {
      "type": "line",
      "data": '.$dataRender.',
      "options": {
         "plugins": {
            "title": {
               "display": true,
               "text": "Biểu đồ tỷ lệ lỗi chất lượng may đầu của cơ sở '.$nameFactory.' '.$time.'"
             }
         },
        "scales": {
          "y": {
            "beginAtZero": true,
            "title": {
              "display": true,
              "text": "Số lượng lỗi"
            }
          },
          "percentage": {
            "beginAtZero": true,
            "position": "right",
            "title": {
              "display": true,
              "text": "Phần trăm tích lũy (%)"
            },
            "grid": {
               "drawOnChartArea": false
            }
          }
        }
      }
    }
   ';
}

$dataChart = '<canvas id="myChart" data-settings=\''.$config.'\'></canvas>';
$data = [
   'dataTable' => $dataTable,
   'dataChart' => $dataChart
];
echo json_encode($data);
}

?>
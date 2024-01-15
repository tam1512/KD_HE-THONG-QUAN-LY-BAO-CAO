<?php 

/**
 * Lỗi nghiêm trọng tính theo: tổng biên bản có lỗi nghiêm trọng / tổng biên bản * 100
 * 
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
 * - all: lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách 12 tháng của tất cả lỗi không phân biệt nhóm
 * - cơ sở: lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách 12 tháng của cơ sở
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
      if($status != 3) {
         if($object != 'all') {
            $sqlTotalInspect = "SELECT SUM(quantity_inspect) as total_inspect FROM reports AS rp $filter AND factory_id = $object";

            $filter .= " $operator f.id=$object";   
            $filterTotal = " $operator rp.factory_id=$object";
            $sql = "SELECT dc.id, dc.name, SUM(rd.defect_quantity) AS total_defect
            FROM report_defect AS rd 
            JOIN reports AS rp ON rp.id = rd.report_id 
            JOIN defects AS df ON df.id = rd.defect_id
            JOIN factories AS f ON rp.factory_id = f.id
            JOIN defect_categories AS dc ON df.cate_id = dc.id
            $filter
            GROUP BY df.cate_id";

            $sqlTotalSerious = "SELECT df.cate_id, SUM(rd.defect_quantity) AS total_serious
            FROM report_defect AS rd 
            JOIN reports AS rp ON rp.id = rd.report_id 
            RIGHT JOIN defects AS df ON df.id = rd.defect_id
            $filterTotal AND rd.level = 'Nghiêm trọng'
            GROUP BY df.cate_id;";
   
            $sqlTotalHeavy = "SELECT df.cate_id, SUM(rd.defect_quantity) AS total_heavy
            FROM report_defect AS rd 
            JOIN reports AS rp ON rp.id = rd.report_id 
            JOIN defects AS df ON df.id = rd.defect_id
            $filterTotal AND rd.level = 'Nặng'
            GROUP BY df.cate_id;";
   
            $sqlTotalLight = "SELECT df.cate_id, SUM(rd.defect_quantity) AS total_light
            FROM report_defect AS rd 
            JOIN reports AS rp ON rp.id = rd.report_id 
            JOIN defects AS df ON df.id = rd.defect_id
            $filterTotal AND rd.level = 'Nhẹ'
            GROUP BY df.cate_id;";
   
            $nameFactory = firstRaw("SELECT name FROM factories WHERE id = $object")['name'];
   
            $listAllCates = getRaw($sql);
            $totalInspect = firstRaw($sqlTotalInspect);
            $listTotalSerious = getRaw($sqlTotalSerious);
            $listTotalHeavy = getRaw($sqlTotalHeavy);
            $listTotalLight = getRaw($sqlTotalLight);
   
            $totalInspectValue = !empty($totalInspect['total_inspect']) ? $totalInspect['total_inspect'] : 0;

            if(!empty($listAllCates)) {
               foreach($listAllCates as $key => $cate) {
                  if(!empty($listTotalSerious)) {
                     foreach($listTotalSerious as $serious) {
                        if($serious['cate_id'] == $cate['id']) {
                           $cate["total_serious"] = $serious['total_serious'];
                           break;
                        } else {
                           $cate["total_serious"] = 0;
                        }
                     }
                  } else {
                     $cate["total_serious"] = 0;
                  }

                  if(!empty($listTotalHeavy)) {
                     foreach($listTotalHeavy as $heavy) {
                        if($heavy['cate_id'] == $cate['id']) {
                           $cate["total_heavy"] = $heavy['total_heavy'];
                           break;
                        } else {
                           $cate["total_heavy"] = 0;
                        }
                     }
                  } else {
                     $cate["total_heavy"] = 0;
                  }

                  if(!empty($listTotalLight)) {
                     foreach($listTotalLight as $light) {
                        if($light['cate_id'] == $cate['id']) {
                           $cate["total_light"] = $light['total_light'];
                           break;
                        } else {
                           $cate["total_light"] = 0;
                        }
                     }
                  } else {
                     $cate["total_light"] = 0;
                  }
                  $listAllCates[$key] = $cate;
               }
            }
            $labels = "";
            $dataTotalSerious = "";
            $dataTotalHeavy = "";
            $dataTotalLight = "";
            $dataPercentSerious = "";
            $dataPercentHeavy = "";
            $dataPercentLight = "";
   
            
            $dataTable = '
            <table class="table table-bordered">
               <tr>
                  <th width="10%">STT</th>
                  <th width="15%">Nhóm lỗi</th>
                  <th>Số lượng kiểm</th>
                  <th>Tổng số lượng lỗi</th>
                  <th>Tổng nghiêm trọng</th>
                  <th>Tổng nặng</th>
                  <th>Tổng nhẹ</th>
                  <th>Tỉ lệ nghiêm trọng</th>
                  <th>Tỉ lệ nặng</th>
                  <th>Tỉ lệ nhẹ</th>
                  <th>Phần trăm tích lũy (%)</th>
               </tr>
            ';
   
            $contentTable = "";
            $count = 0;
            $prevTotal = 0;
            //add phần trăm tích lũy
            foreach($listAllCates as $key=>$item) {
               if(!empty($totalInspectValue)) {
                  $percent = ($prevTotal + $item['total_defect']) / $totalInspectValue * 100;
                  $percentSerious = round($item['total_serious'] / $totalInspectValue * 100, 2);
                  $percentHeavy = round($item['total_heavy'] / $totalInspectValue * 100, 2);
                  $percentLight = round($item['total_light'] / $totalInspectValue * 100, 2);
                  $prevTotal += $item['total_defect'];
               } else {
                  $percent = 0;
                  $percentSerious = 0;
                  $percentHeavy = 0;
                  $percentLight = 0;
                  $prevTotal += $item['total_defect'];
               }
   
               $listAllCates[$key]['percent'] = round($percent, 2);
               $listAllCates[$key]['percent_serious'] = $percentSerious;
               $listAllCates[$key]['percent_heavy'] = $percentHeavy;
               $listAllCates[$key]['percent_light'] = $percentLight;
            }
   
            foreach($listAllCates as $item) {
               $count++;
               $labels .= '"'.$item['name'].'", ';
               $dataTotalSerious .= ''.$item['total_serious'].', ';
               $dataTotalHeavy .= ''.$item['total_heavy'].', ';
               $dataTotalLight .= ''.$item['total_light'].', ';
               $dataPercentSerious .= ''.$item['percent_serious'].', ';
               $dataPercentHeavy .= ''.$item['percent_heavy'].', ';
               $dataPercentLight .= ''.$item['percent_light'].', ';
               $contentTable .= '
               <tr>
                  <td>'.$count.'</td>
                  <td>'.$item['name'].'</td>
                  <td>'.$totalInspectValue.'</td>
                  <td>'.(!empty($item['total_defect']) ? $item['total_defect'] : 0).'</td>
                  <td>'.(!empty($item['total_serious']) ? $item['total_serious'] : 0).'</td>
                  <td>'.(!empty($item['total_heavy']) ? $item['total_heavy'] : 0).'</td>
                  <td>'.(!empty($item['total_light']) ? $item['total_light'] : 0).'</td>
                  <td>'.(!empty($item['percent_serious']) ? $item['percent_serious'] : 0).'</td>
                  <td>'.(!empty($item['percent_heavy']) ? $item['percent_heavy'] : 0).'</td>
                  <td>'.(!empty($item['percent_light']) ? $item['percent_light'] : 0).'</td>
                  <td>'.(!empty($item['percent']) ? $item['percent'] : 0).'</td>
               </tr>
               ';      
            }
   
            $dataTable .= $contentTable.'</table>';
   
            $dataRender = '{
               "labels": ['.trim(trim($labels),',').'],
               "datasets": [
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
                  "backgroundColor": ["rgba(127, 251, 220, 0.2)"],
                  "borderColor": ["rgba(127, 251, 220, 1)"],
                  "borderWidth": 1,
                  "type": "bar",
                  "tension": 0.4
               },
               {
                  "label": "Tổng lỗi nhẹ",
                  "data": ['.trim(trim($dataTotalLight),',').'],
                  "backgroundColor": ["rgba(62, 213, 62, 0.2)"],
                  "borderColor": ["rgba(62, 213, 62, 1)"],
                  "borderWidth": 1,
                  "type": "bar",
                  "tension": 0.4
               },
               {
                  "label": "Tỉ lệ nghiêm trọng",
                  "data": ['.trim(trim($dataPercentSerious),',').'],
                  "backgroundColor": ["rgba(255, 0, 0, 0.2)"],
                  "borderColor": ["rgba(255, 0, 0, 1)"],
                  "borderWidth": 1,
                  "tension": 0.4,
                  "yAxisID": "percentage"
               },
               {
                  "label": "Tỉ lệ nặng",
                  "data": ['.trim(trim($dataPercentHeavy),',').'],
                  "backgroundColor": ["rgba(254, 241, 62, 0.2)"],
                  "borderColor": ["rgba(254, 241, 62, 1)"],
                  "borderWidth": 1,
                  "tension": 0.4,
                  "yAxisID": "percentage"
               },
               {
                  "label": "Tỉ lệ nhẹ",
                  "data": ['.trim(trim($dataPercentLight),',').'],
                  "backgroundColor": ["rgba(62, 225, 250, 0.2)"],
                  "borderColor": ["rgba(62, 225, 250, 1)"],
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
                     "text": "Phần trăm lỗi so với tổng lỗi của cơ sở (%)"
                     },
                     "grid": {
                        "drawOnChartArea": false
                     }
                  }
               }
               }
            }
            ';
         } else {
            //sql lấy tổng số lượng nhận, tổng lỗi kiểm của từng cơ sở
            $sqlFirst = "SELECT f.id, f.name, SUM(quantity_deliver) AS total_deliver, SUM(quantity_inspect) AS total_inspect, SUM(defect_quantity) AS total_defect
            FROM reports AS rp 
            JOIN factories AS f ON f.id = rp.factory_id 
            JOIN report_defect AS rd ON rd.report_id = rp.id
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
                           "percent_light" => round($listAllFactoriesSecond[$key]["total_light"] / $first["total_inspect"] * 100, 2),
                           "percent" => round($first["total_defect"] / $first["total_inspect"] * 100, 2)
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
                        $fac['percent'] = $item['percent'];
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
                        $fac['percent'] = 0;
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
                     'percent_light' => 0,
                     'percent' => 0
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
                  <th>Lỗi nghiêm trọng</th>
                  <th>Lỗi nặng</th>
                  <th>Lỗi nhẹ</th>
                  <th>Tỷ lệ nghiêm trọng (%)</th>
                  <th>Tỷ lệ nặng (%)</th>
                  <th>Tỷ lệ nhẹ (%)</th>
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
                  "label": "Tổng lỗi nghiêm trọng",
                  "data": ['.trim(trim($dataTotalSerious),',').'],
                  "backgroundColor": ["rgba(255, 26, 104, 0.2)"],
                  "borderColor": ["rgba(255, 26, 104, 1)"],
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
      } else {
         if($object == 'all') {
         $sql = "SELECT
            MONTH(ra.create_at) AS month,
            SUM(quantity_serious_real) AS total_serious,
            SUM(quantity_heavy_real) AS total_heavy,
            SUM(quantity_light_real) AS total_light,
            SUM(quantity_inspect) AS total_inspect
            FROM
            resultaql AS ra
            JOIN
            reports AS rp ON rp.id = ra.report_id
            $filter AND MONTH(ra.create_at) BETWEEN 1 AND 12
            GROUP BY
            MONTH(ra.create_at)";
         } else {
            $sql = "SELECT
            MONTH(ra.create_at) AS month,
            SUM(quantity_serious_real) AS total_serious,
            SUM(quantity_heavy_real) AS total_heavy,
            SUM(quantity_light_real) AS total_light,
            SUM(quantity_inspect) AS total_inspect
            FROM
            resultaql AS ra
            JOIN
            reports AS rp ON rp.id = ra.report_id
            $filter AND MONTH(ra.create_at) BETWEEN 1 AND 12 AND rp.factory_id = $object
            GROUP BY
            MONTH(ra.create_at)";
         }
         
         $listMonth = [
            ["month" => 1],
            ["month" => 2],
            ["month" => 3],
            ["month" => 4],
            ["month" => 5],
            ["month" => 6],
            ["month" => 7],
            ["month" => 8],
            ["month" => 9],
            ["month" => 10],
            ["month" => 11],
            ["month" => 12],
         ];

         $listMonthArr = getRaw($sql);
         foreach($listMonth as $key => $m) {
            if(!empty($listMonthArr[$key])) {
               $m['total_serious'] = $listMonthArr[$key]['total_serious'];
               $m['total_heavy'] = $listMonthArr[$key]['total_heavy'];
               $m['total_light'] = $listMonthArr[$key]['total_light'];
               $m['total_inspect'] = $listMonthArr[$key]['total_inspect'];
               $m['percent_serious'] = round($listMonthArr[$key]['total_serious'] / $listMonthArr[$key]['total_inspect'] * 100, 2);
               $m['percent_heavy'] = round($listMonthArr[$key]['total_heavy'] / $listMonthArr[$key]['total_inspect'] * 100, 2);
               $m['percent_light'] = round($listMonthArr[$key]['total_light'] / $listMonthArr[$key]['total_inspect'] * 100, 2);
            } else {
               $m['total_serious'] = 0;
               $m['total_heavy'] = 0;
               $m['total_light'] = 0;
               $m['total_inspect'] = 0;
               $m['percent_serious'] = 0;
               $m['percent_heavy'] = 0;
               $m['percent_light'] = 0;
            }
            $listMonth[$key] = $m;
         }

         $labels = "";

         $dataTotalSerious = "";
         $dataTotalHeavy = "";
         $dataTotalLight = "";

         $dataPercentSerious = "";
         $dataPercentHeavy = "";
         $dataPercentLight = "";

         $dataTable = '
            <table class="table table-bordered">
               <tr>
                  <th>Tháng</th>
                  <th>Số lượng kiểm</th>
                  <th>Lỗi nghiêm trọng</th>
                  <th>Lỗi nặng</th>
                  <th>Lỗi nhẹ</th>
                  <th>Tỷ lệ nghiêm trọng (%)</th>
                  <th>Tỷ lệ nặng (%)</th>
                  <th>Tỷ lệ nhẹ (%)</th>
               </tr>
            ';

            $contentTable = "";
            foreach($listMonth as $item) {
               $labels .= '"'.$item['month'].'", ';
               $dataTotalSerious .= ''.$item['total_serious'].', ';
               $dataTotalHeavy .= ''.$item['total_heavy'].', ';
               $dataTotalLight .= ''.$item['total_light'].', ';
               $dataPercentSerious .= ''.$item['percent_serious'].', ';
               $dataPercentHeavy .= ''.$item['percent_heavy'].', ';
               $dataPercentLight .= ''.$item['percent_light'].', ';

               $contentTable .= '
               <tr>
                  <td> Tháng '.$item['month'].'</td>
                  <td>'.$item['total_inspect'].'</td>
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
                  "label": "Số lỗi nghiêm trọng",
                  "data": ['.trim(trim($dataTotalSerious),',').'],
                  "backgroundColor": ["rgba(255, 26, 104, 0.2)"],
                  "borderColor": ["rgba(255, 26, 104, 1)"],
                  "borderWidth": 1,
                  "type": "bar",
                  "tension": 0.4
               },
               {
                  "label": "Số lỗi lỗi nặng",
                  "data": ['.trim(trim($dataTotalHeavy),',').'],
                  "backgroundColor": ["rgba(234, 154, 0, 0.2)"],
                  "borderColor": ["rgba(234, 154, 0, 1)"],
                  "borderWidth": 1,
                  "type": "bar",
                  "tension": 0.4
               },
               {
                  "label": "Số lỗi nhẹ",
                  "data": ['.trim(trim($dataTotalLight),',').'],
                  "backgroundColor": ["rgba(45, 235, 0, 0.2)"],
                  "borderColor": ["rgba(45, 235, 0, 1)"],
                  "borderWidth": 1,
                  "type": "bar",
                  "tension": 0.4
               },
               {
                  "label": "Tỉ lệ nghiêm trọng",
                  "data": ['.trim(trim($dataPercentSerious),',').'],
                  "backgroundColor": ["rgba(255, 0, 0, 0.2)"],
                  "borderColor": ["rgba(255, 0, 0, 1)"],
                  "borderWidth": 1,
                  "tension": 0.4,
                  "yAxisID": "percentage"
               },
               {
                  "label": "Tỉ lệ nặng",
                  "data": ['.trim(trim($dataPercentHeavy),',').'],
                  "backgroundColor": ["rgba(254, 235, 0, 0.2)"],
                  "borderColor": ["rgba(254, 235, 0, 1)"],
                  "borderWidth": 1,
                  "tension": 0.4,
                  "yAxisID": "percentage"
               },
               {
                  "label": "Tỉ lệ nhẹ",
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
                        "text": "Biểu đồ tỷ lệ lỗi chất lượng may đầu vào theo 12 tháng '.$time.'"
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

$dataChart = '<canvas id="myChart" data-settings=\''.$config.'\'></canvas>';
$data = [
   'dataTable' => $dataTable,
   'dataChart' => $dataChart
];
echo json_encode($data);
}

?>
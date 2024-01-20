<?php 

/**
 * Lỗi nghiêm trọng tính theo: tổng biên bản có lỗi nghiêm trọng / tổng biên bản * 100 
 * 
 * valueType:
 * 1 => theo tháng -> object (all hay cơ sở) 
 * - all : lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách cơ cở, NGHIÊM TRỌNG TÍNH THEO SỐ BIÊN BẢN
 * - cơ sở: lỗi nặng, nhẹ, nghiêm trọng, tỉ lệ lỗi và tỉ lệ phần trăm cộng dồn theo danh sách nhóm lỗi
 * 
 * 2 => Theo năm -> object (all hay cơ sở)
 * - all: giống theo tháng
 * - cơ sở: giống theo tháng
 * 
 * 3 => Theo năm (12 tháng) -> object (all hay cơ sở)
 * - all: lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách 12 tháng của tất cả lỗi không phân biệt nhóm
 * - cơ sở: lỗi nặng, nhẹ, nghiêm trọng và tỉ lệ lỗi theo danh sách 12 tháng của cơ sở,  NGHIÊM TRỌNG TÍNH THEO SỐ BIÊN BẢN
 *  
 * 
 * skip: 
 * - tháng - cơ sở : done
 * - năm - cơ sở : done
 * 
 * - tháng - all (done)
 * - năm - all (done)
 * - 12 tháng - cơ sở ()
 * */

if(isPost()) {
   $body = getBody('post');
   $condition = $body["condition"];
   $object = $condition["valueObj"];
   $status = $condition["valueType"];
   $skip = $condition["valueSkip"];
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

   $isMonth = false;

   $isNotAll = false;
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
      $isMonth = true;
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
            if($skip == 1) {
               $filter.= " AND df.skip = 0";
               $filterTotal.= " AND df.skip = 0";
            }
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
               $dataTotalSerious .= ''.(!empty($item['total_serious']) ? $item['total_serious'] : 0).', ';
               $dataTotalHeavy .= ''.(!empty($item['total_heavy']) ? $item['total_heavy'] : 0).', ';
               $dataTotalLight .= ''.(!empty($item['total_light']) ? $item['total_light'] : 0).', ';
               $dataPercentSerious .= ''.(!empty($item['percent_serious']) ? $item['percent_serious'] : 0).', ';
               $dataPercentHeavy .= ''.(!empty($item['percent_heavy']) ? $item['percent_heavy'] : 0).', ';
               $dataPercentLight .= ''.(!empty($item['percent_light']) ? $item['percent_light'] : 0).', ';
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
                  "backgroundColor": ["rgba(255, 0, 0, 0.2)"],
                  "borderColor": ["rgba(255, 0, 0, 1)"],
                  "borderWidth": 1,
                  "type": "bar",
                  "tension": 0.4
               },
               {
                  "label": "Tổng lỗi nặng",
                  "data": ['.trim(trim($dataTotalHeavy),',').'],
                  "backgroundColor": ["rgba(254, 241, 62, 0.2)"],
                  "borderColor": ["rgba(254, 241, 62, 1)"],
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
                  "backgroundColor": ["rgba(62, 213, 62, 0.2)"],
                  "borderColor": ["rgba(62, 213, 62, 1)"],
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
            if($skip ==  1) {
               $filterFirst = "$filter AND df.skip = 0";
            } else {
               $filterFirst = $filter;
            }
            $sqlTotalDefect = "SELECT f.id, f.name, SUM(defect_quantity) AS total_defect
            FROM reports AS rp 
            JOIN factories AS f ON f.id = rp.factory_id 
            JOIN report_defect AS rd ON rd.report_id = rp.id
            JOIN defects AS df ON rd.defect_id = df.id
            $filterFirst 
            GROUP BY factory_id;";

            $sqlTotalReport = "SELECT factory_id, SUM(quantity_deliver) AS total_deliver, SUM(quantity_inspect) AS total_inspect
            FROM reports as rp
            $filter
            GROUP BY factory_id;";
   
            // sql lấy torng lỗi nhẹ, nặng, nghiêm trọng của từng cơ sở
            //Lấy từ result aql thì sẽ không lấy đượng tổng lỗi có skip = 1
            if($skip == 1) {
               $sqlSecond = "SELECT rp.factory_id, SUM(quantity_serious_real) AS total_serious, SUM(quantity_heavy_real) AS total_heavy, SUM(quantity_light_real) AS total_light 
               FROM resultaql AS ra JOIN reports AS rp ON rp.id = ra.report_id 
               $filter
               GROUP BY rp.factory_id;";
            } else {
               $sqlSerious = "SELECT rp.factory_id, COALESCE(SUM(rd.defect_quantity), 0) AS quantity_serious
               FROM reports AS rp
               LEFT JOIN report_defect AS rd ON rp.id = rd.report_id AND rd.level = 'Nghiêm trọng'
               LEFT JOIN defects AS df ON rd.defect_id = df.id
               $filter
               GROUP BY rp.factory_id;";
               $sqlHeavy = "SELECT rp.factory_id, COALESCE(SUM(rd.defect_quantity), 0) AS quantity_heavy
               FROM reports AS rp
               LEFT JOIN report_defect AS rd ON rp.id = rd.report_id AND rd.level = 'Nặng'
               LEFT JOIN defects AS df ON rd.defect_id = df.id
               $filter
               GROUP BY rp.factory_id;";
               $sqlLight = "SELECT rp.factory_id, COALESCE(SUM(rd.defect_quantity), 0) AS quantity_light
               FROM reports AS rp
               LEFT JOIN report_defect AS rd ON rp.id = rd.report_id AND rd.level = 'Nhẹ'
               LEFT JOIN defects AS df ON rd.defect_id = df.id
               $filter
               GROUP BY rp.factory_id;";
            }

            
            $sqlQuantityReport = "SELECT factory_id, COUNT(id) AS quantity_report FROM reports AS rp $filter GROUP BY factory_id;";
            if($skip == 1) {
               $sqlQuantityReportSerious = "SELECT rp.factory_id, COUNT(rp.ID) AS quantity_report_serious FROM reports AS rp JOIN resultaql AS RA ON RA.report_id = rp.ID $filter AND RA.quantity_serious_real > 0 GROUP BY rp.factory_id;";
            } else {
               $sqlQuantityReportSerious = "SELECT rp.factory_id, COUNT(DISTINCT rp.ID) AS quantity_report_serious 
               FROM reports AS rp 
               JOIN report_defect AS rd ON rd.report_id = rp.id AND rd.level = 'Nghiêm trọng'
               $filter 
               GROUP BY rp.factory_id;";
            }
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
            $listAllFactoriesFirst = [];
            $listTotalDefect = getRaw($sqlTotalDefect);
            $listTotalReport = getRaw($sqlTotalReport);

            foreach($listTotalReport as $key => $value) {
               foreach($listTotalDefect as $k => $v) {
                  if($value['factory_id'] == $v['id']) {
                     $listAllFactoriesFirst[] = [
                        'id' => $v['id'],
                        'factory_id' => $value['factory_id'],
                        'name' => $v['name'],
                        'total_deliver' => $value['total_deliver'],
                        'total_inspect' => $value['total_inspect'],
                        'total_defect' => $v['total_defect'],
                     ];
                     break;
                  }
               }
            }

            if($skip == 1) {
               $listAllFactoriesSecond = getRaw($sqlSecond);
            } else {
               $listAllFactoriesSecond = [];
               $listSerious = getRaw($sqlSerious);
               $listHeavy = getRaw($sqlHeavy);
               $listLight = getRaw($sqlLight);

               if(!empty($listSerious) && !empty($listHeavy) && !empty($listLight)) {
                  foreach($listSerious as $key => $value) {
                     $listAllFactoriesSecond[] = [
                        'factory_id' => $value['factory_id'],
                        'total_serious' => $listSerious[$key]['quantity_serious'],
                        'total_heavy' => $listHeavy[$key]['quantity_heavy'],
                        'total_light' => $listLight[$key]['quantity_light']
                     ];
                  }
               }
               
            }
            if($isMonth) {
               $listQuantityReport = getRaw($sqlQuantityReport);
               $listQuantityReportSerious = getRaw($sqlQuantityReportSerious);
               if(!empty($listQuantityReportSerious)) {
               if(!empty($listQuantityReport)) {
                  foreach($listQuantityReportSerious as $QRS) {
                     foreach($listQuantityReport as $key => $QR) {
                        if($QR['factory_id'] == $QRS['factory_id']) {
                           $listQuantityReport[$key]['quantity_report_serious'] = $QRS['quantity_report_serious'];
                           break;
                        }
                     }
                  }
               }
            } else {
               if(!empty($listQuantityReport)) {
                  foreach($listQuantityReport as $key => $QR) {
                     $listQuantityReport[$key]['quantity_report_serious'] = 0;
                  }
               }
            }
            }

            

            $dataAllFactoties = [];
            if(!empty($listAllFactoriesFirst) && !empty($listAllFactoriesSecond)) {
               foreach($listAllFactoriesFirst as $key => $first) {
                     if($first["id"] == $listAllFactoriesSecond[$key]['factory_id']) {
                        if($isMonth) {
                           $quantityReportSerious = !empty($listQuantityReport[$key]["quantity_report_serious"]) ? $listQuantityReport[$key]["quantity_report_serious"] : 0;
                           $percentSerious = round($quantityReportSerious / $listQuantityReport[$key]["quantity_report"] * 100, 2);
                           $percentHeavy = round($listAllFactoriesSecond[$key]["total_heavy"] / $first["total_inspect"] * 100, 2);
                           $percentLight = round($listAllFactoriesSecond[$key]["total_light"] / $first["total_inspect"] * 100, 2);
                           $dataAllFactoties[] = [
                              "id" => $first["id"],
                              "name" => $first["name"],
                              "total_deliver" => $first["total_deliver"],
                              "total_inspect" => $first["total_inspect"],
                              "total_defect" => $first["total_defect"],
                              "quantity_report_serious" => $quantityReportSerious,
                              "quantity_report" => $listQuantityReport[$key]["quantity_report"],
                              "total_serious" => $listAllFactoriesSecond[$key]["total_serious"],
                              "total_heavy" => $listAllFactoriesSecond[$key]["total_heavy"],
                              "total_light" => $listAllFactoriesSecond[$key]["total_light"],
                              "percent_serious" => $percentSerious,
                              "percent_heavy" => $percentHeavy,
                              "percent_light" => $percentLight,
                              "percent" => round($first["total_defect"] / $first["total_inspect"] * 100, 2),
                              "score" => getScore($percentSerious, $percentHeavy, $percentLight)
                           ];
                        } else {
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

                        if($isMonth) {
                          $fac['quantity_report_serious'] = $item['quantity_report_serious'];
                          $fac['quantity_report'] = $item['quantity_report'];
                          $fac['score'] = $item['score'];
                        }

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
                        if($isMonth) {
                           $fac['quantity_report_serious'] = 0;
                           $fac['quantity_report'] = 0;
                           $fac['score'] = 0;
                         }
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
                  if($isMonth) {
                     $listAllFactories[$key]['quantity_report_serious'] = 0;
                     $listAllFactories[$key]['quantity_report'] = 0;
                     $listAllFactories[$key]['score'] = 0;
                  }
               }
            }

            if($isMonth) {
               $dataTable = '
                        <table class="table table-bordered">
                           <tr>
                              <th>NCC</th>
                              <th>Số lượng giao</th>
                              <th>Số lượng kiểm</th>
                              <th>Tổng lỗi</th>
                              <th>Số báo cáo nghiêm trọng</th>
                              <th>Số báo cáo</th>
                              <th>Lỗi nghiêm trọng</th>
                              <th>Lỗi nặng</th>
                              <th>Lỗi nhẹ</th>
                              <th>Tỷ lệ nghiêm trọng (%)</th>
                              <th>Tỷ lệ nặng (%)</th>
                              <th>Tỷ lệ nhẹ (%)</th>
                              <th>Tỷ lệ lỗi (%)</th>
                              <th>Điểm tháng</th>
                           </tr>
                        ';
            } else {
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
            }
            
   
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
               
               if($isMonth) {
                  $contentTable .= '
                  <tr>
                     <td>'.$item['name'].'</td>
                     <td>'.$item['total_deliver'].'</td>
                     <td>'.$item['total_inspect'].'</td>
                     <td>'.$item['total_defect'].'</td>
                     <td>'.$item['quantity_report_serious'].'</td>
                     <td>'.$item['quantity_report'].'</td>
                     <td>'.$item['total_serious'].'</td>
                     <td>'.$item['total_heavy'].'</td>
                     <td>'.$item['total_light'].'</td>
                     <td>'.$item['percent_serious'].'%</td>
                     <td>'.$item['percent_heavy'].'%</td>
                     <td>'.$item['percent_light'].'%</td>
                     <td>'.$item['percent'].'%</td>
                     <td>'.$item['score'].'</td>
                  </tr>
                  ';
               } else {
                  $contentTable .= '
                  <tr>
                     <td>'.$item['name'].'</td>
                     <td>'.$item['total_deliver'].'</td>
                     <td>'.$item['total_inspect'].'</td>
                     <td>'.$item['total_defect'].'</td>
                     <td>'.$item['total_serious'].'</td>
                     <td>'.$item['total_heavy'].'</td>
                     <td>'.$item['total_light'].'</td>
                     <td>'.$item['percent_serious'].'%</td>
                     <td>'.$item['percent_heavy'].'%</td>
                     <td>'.$item['percent_light'].'%</td>
                     <td>'.$item['percent'].'%</td>
                  </tr>
                  ';
               }
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
         $sql = "";
            $sqlQuantityReportSerious = "";
            $sqlSerious = "";
            $sqlHeavy = "";
            $sqlLight = "";
            $sqlReports = "";
            $sqlReportSerious = "";
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
            if($skip == 1) {
               $sql = "SELECT
               MONTH(ra.create_at) AS month,
               SUM(quantity_serious_real) AS total_serious,
               SUM(quantity_heavy_real) AS total_heavy,
               SUM(quantity_light_real) AS total_light,
               SUM(quantity_inspect) AS total_inspect,
               COUNT(rp.id) AS quantity_report
               FROM
               resultaql AS ra
               JOIN reports AS rp ON rp.id = ra.report_id AND rp.factory_id = $object
               $filter AND MONTH(ra.create_at) BETWEEN 1 AND 12 
               GROUP BY
               MONTH(ra.create_at)";

               $sqlQuantityReportSerious = "SELECT
               MONTH(ra.create_at) AS month,
               COUNT(rp.id) AS quantity_report_serious
               FROM
               resultaql AS ra
               JOIN
               reports AS rp ON rp.id = ra.report_id
               $filter AND MONTH(ra.create_at) BETWEEN 1 AND 12 AND rp.factory_id = $object AND ra.quantity_serious_real > 0
               GROUP BY
               MONTH(ra.create_at)";
            } else {
               $sqlSerious = "SELECT
               MONTH(rp.create_at) AS month,
               SUM(rd.defect_quantity) AS total_serious
               FROM
               reports AS rp
               JOIN report_defect AS rd ON rd.report_id = rp.id AND rd.level = 'Nghiêm trọng'
               $filter AND MONTH(rp.create_at) BETWEEN 1 AND 12 AND rp.factory_id = $object
               GROUP BY
               MONTH(rp.create_at);";

               $sqlHeavy = "SELECT
               MONTH(rp.create_at) AS month,
               SUM(rd.defect_quantity) AS total_heavy
               FROM
               reports AS rp
               JOIN report_defect AS rd ON rd.report_id = rp.id AND rd.level = 'Nặng'
               $filter AND MONTH(rp.create_at) BETWEEN 1 AND 12 AND rp.factory_id = $object
               GROUP BY
               MONTH(rp.create_at);";

               $sqlLight = "SELECT
               MONTH(rp.create_at) AS month,
               SUM(rd.defect_quantity) AS total_light
               FROM
               reports AS rp
               JOIN report_defect AS rd ON rd.report_id = rp.id AND rd.level = 'Nhẹ'
               $filter AND MONTH(rp.create_at) BETWEEN 1 AND 12 AND rp.factory_id = $object
               GROUP BY
               MONTH(rp.create_at);";

               $sqlReports = "SELECT 
               MONTH(rp.create_at) AS month, 
               SUM(rp.quantity_inspect) AS total_inspect, 
               COUNT(rp.id) AS quantity_report 
               FROM reports AS rp
               $filter AND MONTH(rp.create_at) BETWEEN 1 AND 12 AND rp.factory_id = $object
               GROUP BY MONTH(rp.create_at);"; 
               
               $sqlReportSerious = "SELECT 
               MONTH(rp.create_at) AS month,  
               COUNT(DISTINCT rp.id) AS quantity_report_serious
               FROM reports AS rp
               JOIN report_defect AS rd ON rd.report_id = rp.id AND rd.level = 'Nghiêm trọng'
               $filter AND MONTH(rp.create_at) BETWEEN 1 AND 12 AND factory_id = $object
               GROUP BY MONTH(rp.create_at);";
            }
            $isNotAll = true;
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
         if($skip == 1) {
            $listMonthArr = getRaw($sql);
            if(!empty($sqlQuantityReportSerious)) {
               $listMonthSerious = getRaw($sqlQuantityReportSerious);
            }
         } else {
            $listMonthArr = getRaw($sqlReports);
            $listSerious = getRaw($sqlSerious);
            $listHeavy = getRaw($sqlHeavy);
            $listLight = getRaw($sqlLight);
            $listMonthSerious = getRaw($sqlReportSerious);

            if(!empty($listMonthArr)) {
               foreach($listMonthArr as $key => $value) {
                  if(!empty($listSerious)) {
                     foreach($listSerious as $s) {
                        if($s['month'] == $value['month']) {
                           $listMonthArr[$key]['total_serious'] = $s['total_serious'];
                        }
                     }
                  } else {
                     $listMonthArr[$key]['total_serious'] = 0;
                  }

                  if(!empty($listHeavy)) {
                     foreach($listHeavy as $s) {
                        if($s['month'] == $value['month']) {
                           $listMonthArr[$key]['total_heavy'] = $s['total_heavy'];
                        }
                     }
                  } else {
                     $listMonthArr[$key]['total_heavy'] = 0;
                  }

                  if(!empty($listLight)) {
                     foreach($listLight as $s) {
                        if($s['month'] == $value['month']) {
                           $listMonthArr[$key]['total_light'] = $s['total_light'];
                        }
                     }
                  } else {
                     $listMonthArr[$key]['total_light'] = 0;
                  }
               }
            }
         }

         foreach($listMonth as $key => $m) {
            if(!empty($listMonthArr[$key])) {
               $totalSerious = !empty($listMonthArr[$key]['total_serious']) ? $listMonthArr[$key]['total_serious'] : 0;
               $totalHeavy = !empty($listMonthArr[$key]['total_heavy']) ? $listMonthArr[$key]['total_heavy'] : 0;
               $totalLight = !empty($listMonthArr[$key]['total_light']) ? $listMonthArr[$key]['total_light'] : 0;
               if($isNotAll) {
                  if(!empty($listMonthSerious)) {
                     $quantitySerious = 0;
                     foreach($listMonthSerious as $s) {
                        if($s['month'] == $m['month']) {
                           $quantitySerious = $s['quantity_report_serious'];
                           break;
                        }
                     }
                     $percentSerious = round($quantitySerious / $listMonthArr[$key]['quantity_report'] * 100, 2);
                     $m['quantity_report_serious'] = $quantitySerious;
                  } else {
                     $m['quantity_report_serious'] = 0;
                     $percentSerious = 0;
                  }
               } else {
                  $percentSerious = round($totalSerious / $listMonthArr[$key]['total_inspect'] * 100, 2);
               }

               $percentHeavy = round($totalHeavy / $listMonthArr[$key]['total_inspect'] * 100, 2);
               $percentLight = round($totalLight / $listMonthArr[$key]['total_inspect'] * 100, 2);
               $m['total_serious'] = $totalSerious;
               $m['total_heavy'] = $totalHeavy;
               $m['total_light'] = $totalLight;
               $m['total_inspect'] = $listMonthArr[$key]['total_inspect'];
               $m['quantity_report'] = (!empty($listMonthArr[$key]['quantity_report']) ? $listMonthArr[$key]['quantity_report'] : 0);
               $m['percent_serious'] = $percentSerious;
               $m['percent_heavy'] = $percentHeavy;
               $m['percent_light'] = $percentLight;
               if($isNotAll) {
                  $m['score'] = getScore($percentSerious, $percentHeavy, $percentLight);
               }
            } else {
               $m['total_serious'] = 0;
               $m['total_heavy'] = 0;
               $m['total_light'] = 0;
               $m['total_inspect'] = 0;
               $m['quantity_report'] = 0;
               $m['quantity_report_serious'] = 0;
               $m['percent_serious'] = 0;
               $m['percent_heavy'] = 0;
               $m['percent_light'] = 0;
               $m['score'] = 0;
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

         if($isNotAll) {
            $dataTable = '
               <table class="table table-bordered">
                  <tr>
                     <th>Tháng</th>
                     <th>Số lượng kiểm</th>
                     <th>Số báo cáo</th>
                     <th>Số báo cáo nghiêm trọng</th>
                     <th>Lỗi nghiêm trọng</th>
                     <th>Lỗi nặng</th>
                     <th>Lỗi nhẹ</th>
                     <th>Tỷ lệ nghiêm trọng (%)</th>
                     <th>Tỷ lệ nặng (%)</th>
                     <th>Tỷ lệ nhẹ (%)</th>
                     <th>Điểm</th>
                  </tr>
               ';

         } else {
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

         }


            $contentTable = "";
            foreach($listMonth as $item) {
               $labels .= '"'.$item['month'].'", ';
               $dataTotalSerious .= ''.$item['total_serious'].', ';
               $dataTotalHeavy .= ''.$item['total_heavy'].', ';
               $dataTotalLight .= ''.$item['total_light'].', ';
               $dataPercentSerious .= ''.$item['percent_serious'].', ';
               $dataPercentHeavy .= ''.$item['percent_heavy'].', ';
               $dataPercentLight .= ''.$item['percent_light'].', ';

               if($isNotAll) {
                  $contentTable .= '
                  <tr>
                     <td> Tháng '.$item['month'].'</td>
                     <td>'.$item['total_inspect'].'</td>
                     <td>'.$item['quantity_report'].'</td>
                     <td>'.(!empty($item['quantity_report_serious']) ? $item['quantity_report_serious'] : 0).'</td>
                     <td>'.$item['total_serious'].'</td>
                     <td>'.$item['total_heavy'].'</td>
                     <td>'.$item['total_light'].'</td>
                     <td>'.$item['percent_serious'].'%</td>
                     <td>'.$item['percent_heavy'].'%</td>
                     <td>'.$item['percent_light'].'%</td>
                     <td>'.$item['score'].'</td>
                  </tr>
                  ';
                  
               } else {
                  $contentTable .= '
                  <tr>
                     <td> Tháng '.$item['month'].'</td>
                     <td>'.$item['total_inspect'].'</td>
                     <td>'.$item['total_serious'].'</td>
                     <td>'.$item['total_heavy'].'</td>
                     <td>'.$item['total_light'].'</td>
                     <td>'.$item['percent_serious'].'%</td>
                     <td>'.$item['percent_heavy'].'%</td>
                     <td>'.$item['percent_light'].'%</td>
                  </tr>
                  ';

               }

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
                  "label": "Số lỗi nặng",
                  "data": ['.trim(trim($dataTotalHeavy),',').'],
                  "backgroundColor": ["rgba(254, 235, 0, 0.2)"],
                  "borderColor": ["rgba(254, 235, 0, 1)"],
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
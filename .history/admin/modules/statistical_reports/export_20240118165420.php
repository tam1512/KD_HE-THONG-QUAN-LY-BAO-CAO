<?php 
   if(isPost()) {
      $body = getBody('post');
      $data = html_entity_decode($body['data']); //giải mã các ký hiệu thay thế
      if(!empty($data)) {
         $data = json_decode($data, true);
         $nameColumn = $data['name_column'];
         $dataTable = $data['data'];
         $title = utf8_decode($data['title']);
         $arrChar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];

         $lengthNameColumn = count($nameColumn);
         $excel = new PHPExcel();

         $excel->setActiveSheetIndex(0);
         $excel->getActiveSheet()->setTitle($title);

         $excel->getActiveSheet()->getStyle('A1:'.$arrChar[$lengthNameColumn - 1].'1')->getFont()->setBold(true);

         foreach($nameColumn as $key => $name) {
            $excel->getActiveSheet()->setCellValue($arrChar[$key]."1", $name);
         }

         $numRow = 2;
         foreach($dataTable as $dtb) {
            foreach($dtb as $key => $tb) {
               $excel->getActiveSheet()->setCellValue($arrChar[$key].$numRow, $tb);
            }
            $numRow++;
         }

         header('Content-type: application/vnd.ms-excel');
         header('Content-Disposition: attachment; filename="'.$title.time().'.xlsx"');
         PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://ouput');
      }
   }
?>
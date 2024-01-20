<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
   if(isPost()) {
      $body = getBody('post');
      $data = html_entity_decode($body['data']); //giải mã các ký hiệu thay thế
      if(!empty($data)) {
         $data = json_decode($data, true);
         $nameColumn = $data['name_column'];
         $dataTable = $data['data'];
         $title = "Dữ liệu báo cáo";
         $arrChar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];

         $lengthNameColumn = count($nameColumn);

         // Tạo Spreadsheet mới
         $spreadsheet = new Spreadsheet();
         // $spreadsheet->setActiveSheetIndex(0);
         $sheet = $spreadsheet->getActiveSheet();


         $sheet->setTitle($title);

         $sheet->getStyle('A1:'.$arrChar[$lengthNameColumn - 1].'1')->getFont()->setBold(true);

         foreach($nameColumn as $key => $name) {
            $sheet->getColumnDimension($arrChar[$key])->setAutoSize(true);
            $sheet->getStyle($arrChar[$key].'1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
               $sheet->getStyle($arrChar[$key].'1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->setCellValue($arrChar[$key]."1", $name);
         }

         $numRow = 2;
         foreach($dataTable as $dtb) {
            foreach($dtb as $key => $tb) {
               $sheet->getStyle($arrChar[$key].$numRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
               $sheet->getStyle($arrChar[$key].$numRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
               $sheet->setCellValue($arrChar[$key].$numRow, $tb);
            }
            $numRow++;
         }



         // lưu Spreadsheet thành file Excel
         $writer = new Xlsx($spreadsheet);
         // $writer->save('file.xlsx');
         // Đặt header để xác định kiểu file
         header('Content-Type: application/vnd.ms-excel');
         // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         // Đặt header để xác định tên file
         header('Content-Disposition: attachment; filename="'.$title.uniqid().'.xlsx"');

         // Ghi file vào output
         $writer->save('php://output');
      }
   }
?>
<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
   if(isPost()) {
      $body = getBody('post');
      if(isset($body['btnExportExcelStatistical'])) {
         $data = html_entity_decode($body['dataTableExcel']); //giải mã các ký hiệu thay thế
         if(!empty($data)) {
            $data = json_decode($data, true);
            $nameColumn = $data['name_column'];
            $dataTable = $data['data'];
            $title = "Dữ liệu báo cáo";
            $arrChar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
   
            $lengthNameColumn = count($nameColumn);
   
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            //set default font
            $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);
            
            //set title
            $sheet->setTitle($title);

            //heading
            $sheet->setCellValue('A1', 'BÁO CÁO KIỂM TRA CHẤT LƯỢNG MAY ĐẦU VÀO');    

            //Merge headeing
            $sheet->mergeCells("A1:".$arrChar[$lengthNameColumn - 1]."1");

            //set font style
            $sheet->getStyle('A1')->getFont()->setSize(16);
            $sheet->getStyle('A1')->getFont()->setBold(true);

            //set cell alignment
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            foreach($nameColumn as $key => $name) {
               //setting all column
               $sheet->getColumnDimension($arrChar[$key])->setAutoSize(true);
               //set cell alignment for header text
               $sheet->getStyle($arrChar[$key].'2')->getFont()->setBold(true);
               $sheet->getStyle($arrChar[$key].'2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                  $sheet->getStyle($arrChar[$key].'2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
               $sheet->setCellValue($arrChar[$key]."2", $name);
            }
   
            $numRow = 3;
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
   }
?>
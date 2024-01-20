<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
   if(isPost()) {
      $body = getBody('post');
      if(isset($body['btnExportExcelStatistical'])) {
         $data = html_entity_decode($body['dataTableExcel']); //giải mã các ký hiệu thay thế
         if(!empty($data)) {
            $data = json_decode($data, true);
            $nameColumn = $data['name_column'];
            $dataTable = $data['data'];
            $title = "BCCL";
            $arrChar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
   
            $lengthNameColumn = count($nameColumn);
   
            // styling arrays
            //table head style
            $tableHead = [
               'font' => [
                  'color' => [
                     'rgb' => 'FFFFFF'
                  ],
                  'bold'=> true,
                  'size'=> 11
                  ],
                  'fill' => [
                     'fillType' => Fill::FILL_SOLID,
                     'startColor' => [
                        'rgb' => "538ED5",
                     ]
                     ],
                     'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
            ];

            //even row
            $evenRow = [
               'fill' => [
                  'fillType' => Fill::FILL_SOLID,
                  'startColor' => [
                     'rgb' => '00BDFF'
                  ]
               ]
            ];

            //odd row
            $oddRow = [
               'fill' => [
                  'fillType' => Fill::FILL_SOLID,
                  'startColor' => [
                     'rgb' => '00EAFF'
                  ]
               ]
            ];

            // styling arrays end

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
               $sheet->getStyle($arrChar[$key].'2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                  $sheet->getStyle($arrChar[$key].'2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
               $sheet->setCellValue($arrChar[$key]."2", $name);
            }
            
            //set cell alignment for header text and background color
            $sheet->getStyle('A2:'.$arrChar[$lengthNameColumn-1].'2')->applyFromArray($tableHead);
   
            //loop through the data
            //current row
            $numRow = 3;
            foreach($dataTable as $dtb) {
               foreach($dtb as $key => $tb) {
                  $sheet->getStyle($arrChar[$key].$numRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                  $sheet->getStyle($arrChar[$key].$numRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                  $sheet->setCellValue($arrChar[$key].$numRow, $tb);
               }
               if($numRow % 2 == 0) {
                  //even row
                  $sheet->getStyle('A'.$numRow.':'.$arrChar[$lengthNameColumn - 1].$numRow)->applyFromArray($evenRow);
               } else {
                  //odd row
                  $sheet->getStyle('A'.$numRow.':'.$arrChar[$lengthNameColumn - 1].$numRow)->applyFromArray($oddRow);

               }
               $numRow++;
            }

            //autofilter
            //define first row and last row
            $firstRow = 2;
            $lastRow = $numRow - 1;
            //set the autofilter
            $sheet->setAutoFilter('A'.$firstRow.':'.$arrChar[$lengthNameColumn - 1].$lastRow);


            // lưu Spreadsheet thành file Excel
            $writer = new Xlsx($spreadsheet);
            // $writer->save('file.xlsx');
            // Đặt header để xác định kiểu file
            // header('Content-Type: application/vnd.ms-excel');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // Đặt header để xác định tên file
            header('Content-Disposition: attachment; filename="'.$title.'.'.uniqid().'.xlsx"');
   
            // Ghi file vào output
            $writer->save('php://output');
         }
      }
   }
?>
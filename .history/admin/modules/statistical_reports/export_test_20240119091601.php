<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Axis;
use \PhpOffice\PhpSpreadsheet\Chart\Axis\TickMark;
use \PhpOffice\PhpSpreadsheet\Chart\Axis\LabelPosition;
// Tạo một đối tượng Spreadsheet mới
$spreadsheet = new Spreadsheet();

// Lấy sheet hiện tại
$sheet = $spreadsheet->getActiveSheet();

// Đặt tiêu đề cho các cột và hàng
$sheet->setCellValue('A1', 'Tháng');
$sheet->setCellValue('B1', 'Doanh thu');
$sheet->setCellValue('C1', 'Số lượng');

// Đặt dữ liệu cho các ô
$sheet->setCellValue('A2', 'Tháng 1');
$sheet->setCellValue('A3', 'Tháng 2');
$sheet->setCellValue('A4', 'Tháng 3');
$sheet->setCellValue('A5', 'Tháng 4');
$sheet->setCellValue('A6', 'Tháng 5');
$sheet->setCellValue('A7', 'Tháng 6');

$sheet->setCellValue('B2', 1000);
$sheet->setCellValue('B3', 1500);
$sheet->setCellValue('B4', 2000);
$sheet->setCellValue('B5', 1800);
$sheet->setCellValue('B6', 1200);
$sheet->setCellValue('B7', 2500);

$sheet->setCellValue('C2', 10);
$sheet->setCellValue('C3', 15);
$sheet->setCellValue('C4', 20);
$sheet->setCellValue('C5', 18);
$sheet->setCellValue('C6', 12);
$sheet->setCellValue('C7', 25);

// Đặt nhãn cho trục x
$xAxisTickValues = [
   new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Sheet1!$A$2:$A$7', null, 6),
];

$xAxisLabels = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Sheet1!$A$2:$A$7', null, 6);

$xAxisTickMark = new \PhpOffice\PhpSpreadsheet\Chart\Axis\TickMark(
   \PhpOffice\PhpSpreadsheet\Chart\Axis\TickMark::TICK_MARK_OUTSIDE
);

$xAxisLabelPosition = new \PhpOffice\PhpSpreadsheet\Chart\Axis\LabelPosition(
   \PhpOffice\PhpSpreadsheet\Chart\Axis\LabelPosition::LABEL_POSITION_NEXT_TO
);

$xAxis = new Axis();
$xAxis->setAxisOptionsProperties(null, null, null, null, null, null, null, $xAxisLabels, $xAxisTickValues, null, null);
$xAxis->setTickMark($xAxisTickMark);
$xAxis->setLabelPosition($xAxisLabelPosition);

$xAxisTitle = new Title('Tháng'); // Tạo đối tượng Title
$xAxis->setTitle($xAxisTitle);

// Tạo biểu đồ
$chart = new Chart(
    'chart1', // Tên biểu đồ
    null, // Đối tượng plotArea, để trống
    null, // Đối tượng Legend, để trống
    null, // Đối tượng title, để trống
    true, // Hiển thị nhãn dữ liệu trên biểu đồ
    0, // Khởi động từ hàng 0
    'A1', // Điểm bắt đầu biểu đồ
    'C7' // Điểm kết thúc biểu đồ
);

// Đặt tiêu đề cho biểu đồ
$chart->setTitle(new Title('Biểu đồ doanh thu và số lượng'));

// Đặt dữ liệu cho biểu đồ cột
$dataSeries1 = new DataSeries(
    DataSeries::TYPE_BARCHART, // Loại biểu đồ cột
    null, // Đối tượng plotGroup, để trống
    range('Sheet1!$B$2:$B$7'), // Dữ liệu cho series
    range('Sheet1!$A$2:$A$7') // Dữ liệu cho trục x
);
$dataSeries1->setTitle('Doanh thu'); // Đặt tên cho series

// Đặt dữ liệu cho biểu đồ đường
$dataSeries2 = new DataSeries(
    DataSeries::TYPE_LINECHART, // Loại biểu đồ đường
    null, // Đối tượng plotGroup, để trống
    range('Sheet1!$C$2:$C$7'), // Dữ liệu cho series
    range('Sheet1!$A$2:$A$7') // Dữ liệu cho trục x
);
$dataSeries2->setTitle('Số lượng'); // Đặt tên cho series

// Thêm series vào biểu đồ
$chart->plotArea->addChartSeries($dataSeries1);
$chart->plotArea->addChartSeries($dataSeries2);

// Đặt loại biểu đồ
$chart->plotArea->setPlotType(PlotArea::PLOT_TYPE_COMBO);

// Đặt trục y cho series cột
$yAxis = new Axis();
$yAxis->setAxisOptionsProperties('left', null, null, null, null, null, null, null, null);
$chart->plotArea->setYAxis($yAxis);

// Đặt trục y cho series đường
$yAxis2 = new Axis();
$yAxis2->setAxisOptionsProperties('right', null, null, null, null, null, null, null, null);
$chart->plotArea->setYAxis2($yAxis2);

// Đặt nhãn cho trục x
$xAxisTickValues = [
    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Sheet1!$A$2:$A$7', null, 6),
];

$xAxisLabels = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Sheet1!$A$2:$A$7', null, 6);

$xAxisTickMark = new TickMark(
    TickMark::TICK_MARK_OUTSIDE
);

$xAxisLabelPosition = new LabelPosition(
    LabelPosition::LABEL_POSITION_NEXT_TO
);

$xAxis = new Axis();
$xAxis->setAxisOptionsProperties(null, null, null, null, null, null, null, $xAxisLabels, $xAxisTickValues, null, null);
$xAxis->setTickMark($xAxisTickMark);
$xAxis->setLabelPosition($xAxisLabelPosition);
$chart->plotArea->setXAxis($xAxis);

// Đặt tiêu đề cho trục x
$xAxisTitle = new Title('Tháng');
$xAxis->setTitle($xAxisTitle);

// Đặt tiêu đề cho trục y
$yAxisTitle = new Title('Doanh thu');
$yAxis->setTitle($yAxisTitle);

// Đặt tiêu đề cho trục y2
$yAxisTitle2 = new Title('Số lượng');
$yAxis2->setTitle($yAxisTitle2);

// Thêm biểu đồ vào sheet
$chart->setTopLeftPosition('E1');
$chart->setBottomRightPosition('N15');
$sheet->addChart($chart);

// Tạo một đối tượng Writer để xuất tệp Excel
$writer = new Xlsx($spreadsheet);

// Lưu tệp Excel
header('Content-Type: application/vnd.ms-excel');
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// Đặt header để xác định tên file
header('Content-Disposition: attachment; filename="'.uniqid().'.xlsx"');

// Ghi file vào output
$writer->save('php://output');
<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $reportId = $body['id'];
      $reportDetailRows = getRows("SELECT id FROM reports WHERE id = $reportId");
      if($reportDetailRows > 0) {
         $listAllDefects = getRaw("SELECT id FROM report_defect WHERE report_id = $reportId");
         foreach($listAllDefects as $defect) {
            $deleteDefectImage = delete('report_defect_images', "report_defect_id = ".$defect['id']);
         }

         $deleteReportDefect = delete('report_defect', "report_id = $reportId");
         $deleteResultAQL = delete('resultaql', "report_id = $reportId");
         $deleteReport = delete('reports', "id = $reportId");
         if($deleteReport) {
            setFlashData('msg','Xóa thành công');
            setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
      } else {
         setFlashData('msg','Trang không tồn tại');
         setFlashData('msg_type', 'danger');
      } 
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=reports');
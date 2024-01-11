<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$permissionData = getPermissionData($groupId);
$checkPermission = checkPermission($permissionData, 'reports', 'delete');

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Xóa biên bản');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $reportId = $body['id'];
      if(empty($reportId)) {
         setFlashData('msg', 'Báo cáo đã bị xóa');
         setFlashData('msg_type', 'danger');
         redirect("admin/modules=reports");
      }
      $reportDetailRows = getRows("SELECT id FROM reports WHERE id = $reportId");
      if($reportDetailRows > 0) {
         $listAllDefects = getRaw("SELECT id FROM report_defect WHERE report_id = $reportId");
         foreach($listAllDefects as $defect) {
            $deleteDefectImage = delete('report_defect_images', "report_defect_id = ".$defect['id']);
         }

         $deleteReportDefect = delete('report_defect', "report_id = $reportId");
         $deleteResultAQL = delete('resultaql', "report_id = $reportId");
         $deleteReportSign = delete('report_sign', "report_id = $reportId");
         $deleteNotification = delete('notifications', "report_id = $reportId");
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
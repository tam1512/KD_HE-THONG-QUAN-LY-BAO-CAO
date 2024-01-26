<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody('get');
   if(!empty($body['report_id'])) {
      $reportId = $body['report_id'];  
   }
   $keyRD = $body['key'];
   $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
   foreach($listAllReportDefects as $key=>$item) {
      if($key == $keyRD) {
         unset($listAllReportDefects[$key]);
      }
   }
   setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
   setFlashData('msg','Xóa thành công');
   setFlashData('msg_type', 'success');
}
redirect('admin/?module=reports&action=edit&id='.$reportId);
?>
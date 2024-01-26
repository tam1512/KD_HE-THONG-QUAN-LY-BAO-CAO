<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isGet()) {
   $body = getBody('get');
   if(!empty($body['id'])) {
      $reportId = $body['id'];  
   }
   $keyRD = $body['key'];
   if($reportId == "null") {
      $listAllReportDefects = getSession("listAllReportDefectsAdd");
   } else {
      $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
   }
   foreach($listAllReportDefects as $key=>$item) {
      if($key == $keyRD) {
         unset($listAllReportDefects[$key]);
      }
   }
   if($reportId == "null") {
      setSession("listAllReportDefectsAdd", $listAllReportDefects);
   } else {
      setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
   }
   setFlashData('msg','Xóa thành công');
   setFlashData('msg_type', 'success');
}
if($reportId == 'null') {
   redirect('admin/bien-ban/them');
} else {
   redirect('admin/bien-ban/chinh-sua/id='.$reportId);
}
?>
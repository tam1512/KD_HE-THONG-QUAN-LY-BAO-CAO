<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa dịch
 */
if(isPost()) {
   $body = getBody('post');
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
}

echo json_encode($listAllReportDefects);

?>
<?php 
   if(!defined('_INCODE')) die('Access denied...');

   if(!isLogin()) {
     redirect("admin/?module=auth&action=login");
   }
   
   $groupId = getGroupId();
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'reports', 'lists');
   
   if(!$checkPermission) {
     setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý biên bản');
     setFlashData('msg_type', 'danger');
     redirect("admin/");
   }

   $reportId = getBody('get')['id'];
   $action = getBody('get')['action'];

   $link = getLinkAdmin('reports', 'defect_detail', ['id' => $reportId, 'action_old'=>$action]);
   $htmlContent = file_get_contents($link);
   echo $htmlContent;
?>
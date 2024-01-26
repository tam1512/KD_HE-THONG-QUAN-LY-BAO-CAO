<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/dang-nhap");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;

if($isRoot) {
  $checkPermission = true;
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'defects', 'delete');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Xóa lỗi');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $defectId = $body['id'];
      $defectDetailRows = getRows("SELECT id FROM defects WHERE id = $defectId");
      if($defectDetailRows > 0) {
         $reportRows = getRows("SELECT id FROM report_defect WHERE defect_id = $defectId");
         if($reportRows > 0) {
            setFlashData('msg',"Không thể xóa lỗi, còn biên bản có lỗi này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteProduct = delete('defects', "id = $defectId");
            if($deleteProduct) {
               setFlashData('msg','Xóa thành công');
               setFlashData('msg_type', 'success');
            } else {
               setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
               setFlashData('msg_type', 'danger');
            }
         }
      } else {
         setFlashData('msg','Lỗi hệ thông. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      } 
   } else {
      setFlashData('msg','Liên kết không tồn tại');
      setFlashData('msg_type', 'danger');
   }
}
redirect('admin/?module=defects');
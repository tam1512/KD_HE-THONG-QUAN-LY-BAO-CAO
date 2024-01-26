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
  $checkPermission = checkPermission($permissionData, 'factories', 'delete');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Xóa cơ sở');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $factoryId = $body['id'];
      $factoryDetailRows = getRows("SELECT id FROM factories WHERE id = $factoryId");
      if($factoryDetailRows > 0) {
         $reportRows = getRows("SELECT id FROM reports WHERE factory_id = $factoryId");
         if($reportRows > 0) {
            setFlashData('msg',"Không thể xóa cơ sở, còn $reportRows biên bản của cơ sở này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteProduct = delete('factories', "id = $factoryId");
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
redirect('admin/co-so');
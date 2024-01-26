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
  $checkPermission = checkPermission($permissionData, 'defect_categories', 'delete');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Xóa danh mục lỗi');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $cateId = $body['id'];
      $cateDetailRows = getRows("SELECT id FROM defect_categories WHERE id = $cateId");
      if($cateDetailRows > 0) {
         $defectRows = getRows("SELECT id FROM defects WHERE cate_id = $cateId");
         if($defectRows > 0) {
            setFlashData('msg',"Không thể xóa danh mục, còn $defectRows lỗi thuộc danh mục này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('defect_categories', "id = $cateId");
            if($deleteGroup) {
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
redirect('admin/danh-muc-loi');
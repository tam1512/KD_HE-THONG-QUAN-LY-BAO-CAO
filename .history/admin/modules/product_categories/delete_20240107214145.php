<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$permissionData = getPermissionData($groupId);
$checkPermission = checkPermission($permissionData, 'product_categories', 'delete');

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Danh mục sản phẩm');
  setFlashData('msg_type', 'danger');
  redirect("admin/?module=users");
}
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $cateId = $body['id'];
      $cateDetailRows = getRows("SELECT id FROM product_categories WHERE id = $cateId");
      if($cateDetailRows > 0) {
         $productRows = getRows("SELECT id FROM products WHERE cate_id = $cateId");
         if($productRows > 0) {
            setFlashData('msg',"Không thể xóa danh mục, còn $productRows sản phẩm thuộc danh mục này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteGroup = delete('product_categories', "id = $cateId");
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
redirect('admin/?module=product_categories');
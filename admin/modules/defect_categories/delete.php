<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa danh mục sản phẩm
 */
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
redirect('admin/?module=defect_categories');
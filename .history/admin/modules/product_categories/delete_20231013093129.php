<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa danh mục sản phẩm
 */
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
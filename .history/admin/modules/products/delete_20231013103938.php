<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa sản phẩm
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $productId = $body['id'];
      $productDetailRows = getRows("SELECT id FROM products WHERE id = $productId");
      if($productDetailRows > 0) {
         $reportRows = getRows("SELECT id FROM reports WHERE product_id = $productId");
         if($reportRows > 0) {
            setFlashData('msg',"Không thể xóa sản phẩm, còn $reportRows biên bản của sản phẩm này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteProduct = delete('products', "id = $productId");
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
redirect('admin/?module=products');
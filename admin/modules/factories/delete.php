<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa
 */
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
redirect('admin/?module=factories');
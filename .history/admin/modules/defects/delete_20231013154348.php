<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa lỗi
 */
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
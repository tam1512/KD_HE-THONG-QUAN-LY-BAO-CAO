<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng xóa danh mục biên bản
 */
if(isGet()) {
   $body = getBody();
   if(!empty($body['id'])) {
      $cateId = $body['id'];
      $cateDetailRows = getRows("SELECT id FROM report_categories WHERE id = $cateId");
      if($cateDetailRows > 0) {
         $reportRows = getRows("SELECT id FROM reports WHERE cate_id = $cateId");
         if($reportRows > 0) {
            setFlashData('msg',"Không thể xóa danh mục, còn $reportRows biên bản trong danh mục này");
            setFlashData('msg_type', 'danger');
         } else {
            $deleteCate = delete('report_categories', "id = $cateId");
            if($deleteCate) {
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
redirect('admin/?module=report_categories');
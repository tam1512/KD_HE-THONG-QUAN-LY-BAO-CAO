<?php 
   if(isGet()) {
      $body = getBody('get');
      $reportId = $body['id'];

      $reportSign = firstRaw("SELECT sign_text_GC FROM report_sign WHERE report_id = $reportId");
      if(!empty($reportSign['sign_text_GC'])) {
         $dataUpdate = [
            'status' => 1
         ];
         $statusUpdate = update('reports', $dataUpdate, "id = $reportId");
         if($statusUpdate) {
            setFlashData('msg', 'Xác nhận báo cáo thành công');
            setFlashData('msg_type', 'success');
            redirect("admin/modules=reports");
         } else {
            setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sao');
            setFlashData('msg_type', 'danger');
            redirect("admin/modules=reports");
         }
      }
   }
?>
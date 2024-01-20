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

         
         //Thêm thông báo cho report
         $userXXNoti = '{"user_id":'.$userXXId.', "seen":2, "sign":2, "show": 2, "create_at":"'.date('d-m-Y H:i:s').'"}';
         $userQDNoti = '{"user_id":'.$userQDId.', "seen":2, "sign":2, "show": 2, "create_at":"'.date('d-m-Y H:i:s').'"}';
         $userKTNoti = '{"user_id":'.$userId.', "seen":2, "sign":1, "show": 2, "create_at":"'.date('d-m-Y H:i:s').'"}';
         $dataInsertNoti = [
            'report_id' => $reportId,
            'code_report' => $codeReport,
            "userXX" => $userXXNoti,
            "userQD" => $userQDNoti,
            "userKT" => $userKTNoti
         ];

         $statusinsertNoti = insert('notifications', $dataInsertNoti);

         if($statusUpdate && $statusinsertNoti) {
            setFlashData('msg', 'Xác nhận báo cáo thành công');
            setFlashData('msg_type', 'success');
            redirect("admin/?modules=reports");
         } else {
            setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sao');
            setFlashData('msg_type', 'danger');
            redirect("admin/?modules=reports");
         }
      } else {
         setFlashData('msg', 'Cơ sở gia công chưa ký, không thể xác nhận báo cáo');
            setFlashData('msg_type', 'danger');
            redirect("admin/?modules=reports&action=seen&id=$reportId");
      }
   }
?>
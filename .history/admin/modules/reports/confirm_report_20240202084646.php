<?php 
   if(isGet()) {
      $body = getBody('get');
      $reportId = $body['id'];

      $reportSign = firstRaw("SELECT * FROM report_sign WHERE report_id = $reportId");
      $report = firstRaw("SELECT code_report FROM reports WHERE id = $reportId");
      if(!empty($reportSign['sign_text_GC'])) {
         $dataUpdate = [
            'status' => 1
         ];
         $statusUpdate = update('reports', $dataUpdate, "id = $reportId");

         $userXX = json_decode($reportSign['userXX'], true);
         $userQD = json_decode($reportSign['userQD'], true);

         $userXXId = $userXX['user_id'];
         $userQDId = $userQD['user_id'];
         $userId = isLogin()['user_id'];
         
         //Thêm thông báo cho report
         $userXXNoti = '{"user_id":'.$userXXId.', "seen":2, "sign":2, "show": 2, "create_at":"'.date('d-m-Y H:i:s').'"}';
         $userQDNoti = '{"user_id":'.$userQDId.', "seen":2, "sign":2, "show": 2, "create_at":"'.date('d-m-Y H:i:s').'"}';
         $userKTNoti = '{"user_id":'.$userId.', "seen":2, "sign":1, "show": 2, "create_at":"'.date('d-m-Y H:i:s').'"}';
         $dataInsertNoti = [
            'report_id' => $reportId,
            'code_report' => $report['code_report'],
            "userXX" => $userXXNoti,
            "userQD" => $userQDNoti,
            "userKT" => $userKTNoti
         ];

         $statusinsertNoti = insert('notifications', $dataInsertNoti);

         if($statusUpdate && $statusinsertNoti) {
            setFlashData('msg', 'Xác nhận báo cáo thành công');
            setFlashData('msg_type', 'success');
            redirect("admin/bien-ban");
         } else {
            setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sao');
            setFlashData('msg_type', 'danger');
            redirect("admin/bien-ban");
         }
      } else {
         setFlashData('msg', 'Cơ sở gia công chưa ký, không thể xác nhận báo cáo');
            setFlashData('msg_type', 'danger');
            redirect("admin/bien-ban/xem/id=$reportId");
      }
   }
?>
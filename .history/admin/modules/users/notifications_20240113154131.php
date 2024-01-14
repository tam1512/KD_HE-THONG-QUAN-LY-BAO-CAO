<?php 
   $id = isLogin()['user_id'];
   $listAllNotifications = getRaw("SELECT * FROM notifications");
   $listNotificationsByUser = null;
   if(!empty($listAllNotifications)) {
      foreach($listAllNotifications as $noti) {
         $reportId = $noti['report_id'];
         $codeReport = firstRaw("SELECT code_report FROM reports WHERE id = $reportId")['code_report'];
         $userXX = json_decode($noti['userXX'], true);
         $userQD = json_decode($noti['userQD'], true);
         $userPD = json_decode($noti['userPD'], true);
         $userKT = json_decode($noti['userKT'], true);

         if(!empty($userXX['user_id']) && $id == $userXX['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userXX['seen'],
               "sign" => $userXX['sign'],
               "delete" => !empty($userXX['delete']) ? $userXX['delete'] : false,
               "create_at" => $userXX['create_at'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userQD['user_id']) && $id == $userQD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userQD['seen'],
               "sign" => $userQD['sign'],
               "delete" => !empty($userQD['delete']) ? $userQD['delete'] : false,
               "create_at" => $userQD['create_at'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userPD['user_id']) && $id == $userPD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userPD['seen'],
               "sign" => $userPD['sign'],
               "delete" => !empty($userPD['delete']) ? $userPD['delete'] : false,
               "create_at" => $userPD['create_at'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userKT['user_id']) && $id == $userKT['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userKT['seen'],
               "sign" => $userKT['sign'],
               "delete" => !empty($userKT['delete']) ? $userKT['delete'] : false,
               "create_at" => $userKT['create_at'],
               "report_id" => $reportId
            ];
         }
      }
   }

   // Sắp xếp mảng theo thứ tự thời gian từ gần nhất đến xa nhất
   if(!empty($listNotificationsByUser)) {
      usort($listNotificationsByUser, function($a, $b) {
         $timeA = strtotime($a['create_at']);
         $timeB = strtotime($b['create_at']);
         return $timeB - $timeA;
      });
   }


      //đếm số biên bản chưa ký
      $countReportUnsigned = 0;
      foreach($listNotificationsByUser as $noti) {
         if($noti['sign'] == 2) {
            $countReportUnsigned++;
         }
      } 


   $body = getBody('post');
   $count = !empty($body['count']) ? $body['count'] : false;
   $list = !empty($body['list']) ? $body['list'] : false;


   if(!empty($count)) {
      echo $countReportUnsigned;
      return;
   }

   if(!empty($list)):
?>
<span class="dropdown-item dropdown-header">Bạn có
   <?php echo $countReportUnsigned ?> biên bản chưa ký</span>
<div class="dropdown-divider"></div>
<div class="notification-list">
   <?php 
      if(!empty($listNotificationsByUser)):
         foreach($listNotificationsByUser as $noti):
            $isDelete = $noti['delete'];
   ?>
   <a href="<?php echo getLinkAdmin('reports', 'seen', ['id' => $noti['report_id'], 'seen' => 1]) ?>"
      class="dropdown-item  <?php echo ($noti['seen'] == 1) ? '' : 'bg-light' ?> d-flex align-items-center justify-content-between">
      <i class="nav-icon fas fa-file mr-2"></i> Mã biên bản: <?php echo $noti['code_report'] ?>
      <div class="d-flex flex-column">
         <?php 
         if(empty($noti['delete'])) {
            echo ($noti['sign'] == 1) ? '<span class="float-right text-success text-sm">Đã ký</span>' : '<span class="float-right text-danger text-sm">Chưa ký</span>';
         } else if($noti['delete'] == 1) {
            echo '<span class="float-right text-danger text-sm">Chưa ký</span>'
         }
          ?>
         <?php echo ($noti['seen'] == 1) ? '<span class="float-right text-muted text-sm">Đã xem</span>' : false ?>
      </div>
   </a>
   <?php endforeach; endif; ?>
</div>
<?php endif; ?>
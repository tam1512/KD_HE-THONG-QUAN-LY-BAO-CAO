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
               "create_at" => $userXX['create_at'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userQD['user_id']) && $id == $userQD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userQD['seen'],
               "sign" => $userQD['sign'],
               "create_at" => $userQD['create_at'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userPD['user_id']) && $id == $userPD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userPD['seen'],
               "sign" => $userPD['sign'],
               "create_at" => $userPD['create_at'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userKT['user_id']) && $id == $userKT['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userKT['seen'],
               "sign" => $userKT['sign'],
               "create_at" => $userKT['create_at'],
               "report_id" => $reportId
            ];
         }
      }
   }

   // Sắp xếp mảng theo thứ tự thời gian từ gần nhất đến xa nhất

   
   if(!empty($listNotificationsByUser)) {
      echo '<pre>';
      print_r($listNotificationsByUserrr);
      echo '</pre>';
      usort($listNotificationsByUser, function($a, $b) {
         $timeA = strtotime($a['created_at']);
         $timeB = strtotime($b['created_at']);
         return $timeB - $timeA;
      });
   }

   $body = getBody('post');
   $count = !empty($body['count']) ? $body['count'] : false;
   $list = !empty($body['list']) ? $body['list'] : false;


   if(!empty($count)) {
      echo !empty($listNotificationsByUser) ? count($listNotificationsByUser) : 0;
      return;
   }

   if(!empty($list)):
?>
<span class="dropdown-item dropdown-header">Bạn có
   <?php echo !empty($listNotificationsByUser) ? count($listNotificationsByUser) : 0 ?> thông
   báo</span>
<div class="dropdown-divider"></div>
<div class="notification-list">
   <?php 
      if(!empty($listNotificationsByUser)):
         foreach($listNotificationsByUser as $noti):
   ?>
   <a href="<?php echo getLinkAdmin('reports', 'seen', ['id' => $noti['report_id'], 'seen' => 1]) ?>"
      class="dropdown-item  <?php echo ($noti['seen'] == 1) ? '' : 'bg-light' ?> d-flex align-items-center justify-content-between">
      <i class="nav-icon fas fa-file mr-2"></i> Số: <?php echo $noti['code_report'] ?>
      <div class="d-flex flex-column">
         <?php echo ($noti['sign'] == 1) ? '<span class="float-right text-success text-sm">Đã ký</span>' : '<span class="float-right text-danger text-sm">Chưa ký</span>' ?>
         <?php echo ($noti['seen'] == 1) ? '<span class="float-right text-muted text-sm">Đã xem</span>' : false ?>
      </div>
   </a>
   <?php endforeach; endif; ?>
</div>
<?php endif; ?>
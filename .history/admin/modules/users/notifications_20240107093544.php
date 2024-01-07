<?php 
   $listAllNotifications = getRaw("SELECT * FROM notifications");
   $listNotificationsByUser = null;
   if(!empty($listAllNotifications)) {
      foreach($listAllNotifications as $noti) {
         $reportId = $noti['report_id'];
         $codeReport = firstRaw("SELECT code_report FROM reports WHERE id = $reportId")['code_report'];
         $userXX = json_decode($noti['userXX'], true);
         $userQD = json_decode($noti['userQD'], true);
         $userPD = json_decode($noti['userPD'], true);

         if(!empty($userXX['user_id']) && $id == $userXX['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userXX['seen'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userQD['user_id']) && $id == $userQD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userQD['seen'],
               "report_id" => $reportId
            ];
         }

         if(!empty($userPD['user_id']) && $id == $userPD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userPD['seen'],
               "report_id" => $reportId
            ];
         }
      }
   }
?>


<li class="nav-item dropdown" id="notification">
   <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell"></i>
      <span
         class="badge badge-danger navbar-badge"><?php echo !empty($listNotificationsByUser) ? count($listNotificationsByUser) : 0 ?></span>
   </a>
   <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
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
            class="dropdown-item  <?php echo ($noti['seen'] == 1) ? '' : 'bg-light' ?>">
            <i class="nav-icon fas fa-file mr-2"></i> Số: <?php echo $noti['code_report'] ?>
            <?php echo ($noti['seen'] == 1) ? '<span class="float-right text-muted text-sm">Đã xem</span>' : false ?>
         </a>
         <?php endforeach; endif; ?>
      </div>
   </div>
</li>
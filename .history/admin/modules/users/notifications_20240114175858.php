<?php 
   $id = isLogin()['user_id'];
   $listAllNotifications = getRaw("SELECT * FROM notifications");
   $listNotificationsByUser = null;
   if(!empty($listAllNotifications)) {
      foreach($listAllNotifications as $noti) {
         $reportId = $noti['report_id'];
         $codeReport = firstRaw("SELECT code_report FROM notifications WHERE report_id = $reportId")['code_report'];
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
               "show" => !empty($userXX['show']) ? $userXX['show'] : false,
               "create_at" => $userXX['create_at'],
               "report_id" => $reportId,
               "content" => "Bạn được chọn làm người xem xét của báo cáo này",
               "is_KT" => false,
               "is_XX" => true,
               "is_QD" => false,
               "is_PD" => false,

            ];
         }

         if(!empty($userQD['user_id']) && $id == $userQD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userQD['seen'],
               "sign" => $userQD['sign'],
               "delete" => !empty($userQD['delete']) ? $userQD['delete'] : false,
               "show" => !empty($userQD['show']) ? $userQD['show'] : false,
               "create_at" => $userQD['create_at'],
               "report_id" => $reportId,
               "content" => "Bạn được chọn làm người ký báo cáo này",
               "is_KT" => false,
               "is_XX" => false,
               "is_QD" => true,
               "is_PD" => false,
            ];
         }

         if(!empty($userPD['user_id']) && $id == $userPD['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userPD['seen'],
               "sign" => $userPD['sign'],
               "delete" => !empty($userPD['delete']) ? $userPD['delete'] : false,
               "show" => !empty($userPD['show']) ? $userPD['show'] : false,
               "create_at" => $userPD['create_at'],
               "report_id" => $reportId,
               "content" => "Bạn được chọn làm người phê duyệt của báo cáo này",
               "is_KT" => false,
               "is_XX" => false,
               "is_QD" => false,
               "is_PD" => true,
            ];
         }

         if(!empty($userKT['user_id']) && $id == $userKT['user_id']) {
            $listNotificationsByUser[] = [
               "code_report" => $codeReport,
               "seen" => $userKT['seen'],
               "sign" => $userKT['sign'],
               "delete" => !empty($userKT['delete']) ? $userKT['delete'] : false,
               "show" => !empty($userKT['show']) ? $userKT['show'] : false,
               "create_at" => $userKT['create_at'],
               "report_id" => $reportId,
               "content" => "Tạo và ký báo cáo thành công",
               "is_KT" => true,
               "is_XX" => false,
               "is_QD" => false,
               "is_PD" => false,
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
      if(!empty($listNotificationsByUser)) {
         foreach($listNotificationsByUser as $noti) {
            if($noti['sign'] == 2 && empty($noti['delete'])) {
               $countReportUnsigned++;
            }
         } 
      }


   $body = getBody('post');
   $count = !empty($body['count']) ? $body['count'] : false;
   $list = !empty($body['list']) ? $body['list'] : false;
   $toast = !empty($body['toast']) ? $body['toast'] : false; 

   
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
            $isDelete = ($noti['delete'] == 1) ? true : false;
   ?>
   <a href="<?php echo getLinkAdmin('reports', 'seen', ['id' => $noti['report_id'], 'seen' => 1]) ?>"
      class="dropdown-item  <?php echo ($noti['seen'] == 1) ? '' : 'bg-light' ?> d-flex align-items-center justify-content-between <?php echo ($isDelete) ? 'disabled' : false ?>">
      <i class="nav-icon fas fa-file mr-2"></i> Mã biên bản: <?php echo $noti['code_report'] ?>
      <div class="d-flex flex-column">
         <?php 
         if($isDelete) {
            echo '<span class="float-right text-danger text-sm">Đã xóa</span>';
         } else {
            echo ($noti['sign'] == 1) ? '<span class="float-right text-success text-sm">Đã ký</span>' : '<span class="float-right text-danger text-sm">Chưa ký</span>';
         }
          ?>
         <?php echo ($noti['seen'] == 1) ? '<span class="float-right text-muted text-sm">Đã xem</span>' : false ?>
      </div>
   </a>
   <?php endforeach; endif; ?>
</div>
<div class="dropdown-divider"></div>
<span class="dropdown-item"></span>
<?php return; endif;?>
<?php
if(!empty($toast)):
   if(!empty($listNotificationsByUser)):
      foreach($listNotificationsByUser as $n):
         if(!empty($n['show']) && $n['show'] == 2):
?>
<audio id="toast-audio" class="d-none" controls autoplay>
   <source src="<?php echo _WEB_HOST_ROOT_ADMIN."\modules\\reports\audios\\noti.wav" ?>" type="audio/mp3">
   Your browser does not support the audio element.
</audio>
<a href="<?php echo getLinkAdmin('reports', 'seen', ['id' => $n['report_id']]) ?>">
   <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
      <div class="toast-header">
         <i class="nav-icon fas fa-file rounded mr-2"></i>
         <strong class="mr-auto"><?php echo $n['code_report'] ?></strong>
         <small class="text-muted"><?php echo getDateFormat($n['create_at'], 'H:i:s') ?></small>
         <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="toast-body text-muted">
         <?php echo $n['content'] ?>
      </div>
   </div>
</a>
<?php 
            
            $notiReport = firstRaw("SELECT * FROM notifications WHERE report_id =".$n['report_id']);
            if($n['is_KT']) {
               $userKT = json_decode($notiReport['userKT'], true);
               $userKT['show'] = 1;
               $dataUpdate = [
                  'userKT' => json_encode($userKT)
               ];
               update('notifications', $dataUpdate, "report_id = ".$n['report_id']);
            }
            if($n['is_XX']) {
               $userXX = json_decode($notiReport['userXX'], true);
               $userXX['show'] = 1;
               $dataUpdate = [
                  'userXX' => json_encode($userXX)
               ];
               update('notifications', $dataUpdate, "report_id = ".$n['report_id']);
            }
            if($n['is_QD']) {
               $userQD = json_decode($notiReport['userQD'], true);
               $userQD['show'] = 1;
               $dataUpdate = [
                  'userQD' => json_encode($userQD)
               ];
               update('notifications', $dataUpdate, "report_id = ".$n['report_id']);
            }
            if($n['is_PD']) {
               $userPD = json_decode($notiReport['userPD'], true);
               $userPD['show'] = 1;
               $dataUpdate = [
                  'userPD' => json_encode($userPD)
               ];
               update('notifications', $dataUpdate, "report_id = ".$n['report_id']);
            }
         endif; 
      endforeach; 
   endif;
endif ?>
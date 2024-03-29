<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/dang-nhap");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;

if($isRoot) {
   $checkPermission = true;
   $isSignGC = true;
   $isChangeStatus = true;
} else {
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'reports', 'seen');
   $isSignGC = checkPermission($permissionData, 'reports', 'sign_gc');
   $isChangeStatus = checkPermission($permissionData, 'reports', 'change_status');
}


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Xem biên bản');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Nội dung biên bản'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 
 $msg = getFlashData('msg');
 $msgType = getFlashData('msg_type');
 
$userId = isLogin()['user_id'];

if(isGet()) {
   $reportId = getBody('get')['id'];
   $seen = !empty(getBody('get')['seen']) ? getBody('get')['seen'] : false;

   if(empty($reportId)) {
      setFlashData('msg', 'Báo cáo đã bị xóa');
      setFlashData('msg_type', 'danger');
      redirect("admin/bao-cao");
   } else {
      if(!checkId('reports', $reportId)) {
        require_once _WEB_PATH_ROOT.'/modules/errors/404.php';
        die();
      }
   }
}

   if(!empty($seen)) {
      $notification = firstRaw("SELECT userXX, userQD, userPD, userKT FROM notifications WHERE report_id = $reportId");
      $userXX = json_decode($notification['userXX'], true);
      $userQD = json_decode($notification['userQD'], true);
      $userPD = json_decode($notification['userPD'], true);
      $userKT = json_decode($notification['userKT'], true);
      
      $dataUpdateNoti = [];

      if(!empty($userXX) && $userXX['user_id'] == $userId) {
         $userXX['seen'] = $seen;

         $dataUpdateNoti = [
            'userXX' => json_encode($userXX)
         ];
      }

      if(!empty($userQD) && $userQD['user_id'] == $userId) {
         $userQD['seen'] = $seen;

         $dataUpdateNoti = [
            'userQD' => json_encode($userQD)
         ];
      }

      if(!empty($userPD) && $userPD['user_id'] == $userId) {
         $userPD['seen'] = $seen;

         $dataUpdateNoti = [
            'userPD' => json_encode($userPD)
         ];
      }

      if(!empty($userKT) && $userKT['user_id'] == $userId) {
         $userKT['seen'] = $seen;

         $dataUpdateNoti = [
            'userKT' => json_encode($userKT)
         ];
      }

      update('notifications', $dataUpdateNoti, "report_id=$reportId");
      redirect("admin/bao-cao/xem/id=$reportId");
   }
   

   getMsg($msg, $msgType);

   require_once('defect_detail.php');

?>
<div class="container-fluid pb-16">
   <a class="btn btn-success mt-2" href="<?php echo getLinkAdmin('reports') ?>">Quay lại</a>
   <?php if($statusSign == 1): ?>
   <a class="btn btn-primary mt-2" href="<?php echo getLinkAdmin('reports', 'edit', ['id'=>$reportId]) ?>">Chỉnh sửa</a>
   <?php endif; if($statusSign == 1 && $report['status'] == 5):?>
   <a href="<?php echo getLinkAdmin("reports", "confirm_report", ['id' => $reportId]) ?>" class="btn btn-dark mt-2">Xác
      nhận báo cáo</a>
   <?php endif;if($statusSign == 2): ?>
   <a class="btn btn-danger mt-2" href="<?php echo getLinkAdmin('reports', 'quick_sign', ['id'=>$reportId]) ?>">Xác nhận
      ký</a>
   <?php endif; ?>
   <a href="<?php echo getLinkAdmin('reports', 'export', ['id' => $reportId]) ?>" target="_blank"
      class="btn btn-warning mt-2">Xuất PDF</a>
</div>
<?php
   layout('footer','admin');
 ?>
<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh danh mục sản phẩm
 */
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
}

   if(!empty($seen)) {
      $notification = firstRaw("SELECT userXX, userQD, userPD FROM notifications WHERE report_id = $reportId");
      $userXX = json_decode($notification['userXX'], true);
      $userQD = json_decode($notification['userQD'], true);
      $userPD = json_decode($notification['userPD'], true);
      
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

      update('notifications', $dataUpdateNoti, "report_id=$reportId");
      redirect("admin/?module=reports&action=seen&id=$reportId");
   }

   getMsg($msg, $msgType);

   require_once('defect_detail.php');

?>
<div class="container  pb-16">
   <a class="btn btn-success" href="<?php echo getLinkAdmin('reports') ?>">Quay lại</a>
   <?php if($statusSign == 1): ?>
   <a class="btn btn-primary" href="<?php echo getLinkAdmin('reports', 'edit', ['id'=>$reportId]) ?>">Chỉnh sửa</a>
   <?php elseif($statusSign == 2): ?>
   <a class="btn btn-danger" href="<?php echo getLinkAdmin('users', 'quick_sign', ['report_id'=>$reportId]) ?>">Xác nhận
      ký</a>
   <?php endif; ?>
   <a class="btn btn-warning export" href="<?php echo getLinkAdmin('reports', 'export', ['id'=>$reportId]) ?>">Xuất
      PDF</a>
</div>
<?php
   layout('footer','admin');
 ?>
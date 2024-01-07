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
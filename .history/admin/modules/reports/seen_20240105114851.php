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

if(isGet()) {
   $reportId = getBody('get')['id'];
}

   require_once('defect_detail.php');

?>
<div class="container  pb-16">
   <a class="btn btn-success" href="<?php echo getLinkAdmin('reports') ?>">Quay lại</a>
   <a class="btn btn-primary" href="<?php echo getLinkAdmin('reports', 'edit', ['id'=>$reportId]) ?>">Chỉnh sửa
      <?php echo $status_userXX ?></a>
   <a class="btn btn-warning export" href="<?php echo getLinkAdmin('reports', 'export', ['id'=>$reportId]) ?>">Xuất
      PDF</a>
</div>
<?php
   layout('footer','admin');
 ?>
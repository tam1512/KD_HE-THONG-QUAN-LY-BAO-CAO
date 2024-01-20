<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh danh mục sản phẩm
 */
$data = [
   'title' => 'Xem ảnh của lỗi'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

if(isGet()) {
   $keyRD = getBody('get')['key'];
   $reportId = getBody('get')['report_id'];
}
if($reportId == 'null') {
   $listAllReportDefects = getSession("listAllReportDefectsAdd");
} else {
   $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
}
foreach($listAllReportDefects as $key=>$value) {
   if($keyRD == $key) {
      $currentReportDefect = $value;
   }
}
$nameDefect = $currentReportDefect['name'];
if(!empty($currentReportDefect['files'])) {
   $listFiles = $currentReportDefect['files'];
}

 ?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <h4><?php echo $nameDefect ?></h4>

         <?php 
            if(!empty($listFiles)):
               foreach($listFiles as $file):
         ?>
         <p><u>Tên ảnh: </u> <?php echo $file['fileOr'] ?></p>
         <img src="<?php echo $file['link'] ?>" alt="<?php echo $file['fileOr'] ?>" style="width:70%">
         <br>
         <hr>
         <?php 
               endforeach;
            else:
         ?>
         <div class="alert alert-danger">Không có ảnh</div>
         <?php 
            endif;
         ?>
         <?php
            $old = ($reportId == 'null') ? 'add' : 'edit';
         ?>
         <a href="<?php echo getLinkAdmin('reports', $old, ['id' => $reportId]) ?>" class="btn btn-success">Quay
            lại</a>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
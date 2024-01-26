<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh danh mục sản phẩm
 */
$data = [
   'title' => 'Xem ảnh của lỗi'
];

if(isGet()) {
   if(!empty(getBody('get')['report_defect_id'])) {
      $reportDefectId = getBody('get')['report_defect_id'];
   }
   if(!empty(getBody('get')['id'])) {
      $reportId = getBody('get')['id'];
   }
   
   if(!empty(getBody('get')['action_old'])) {
      $actionOld = getBody('get')['action_old'];
   }
}

   if(empty($actionOld)) {
      layout('header', 'admin', $data);
      layout('sidebar', 'admin', $data);
      layout('breadcrumb', 'admin', $data);  
   } else {
      layout('header-non', 'admin', $data);
   }

 // Xử lý 
$listAllImages = getRaw("SELECT * FROM report_defect_images WHERE report_defect_id = $reportDefectId");
$nameDefect = firstRaw("SELECT df.name FROM report_defect AS rd JOIN defects as df ON df.id = rd.defect_id WHERE rd.id = $reportDefectId")['name'];

 ?>
<?php 
if(!empty($actionOld)):
   if(!empty($listAllImages)): 
      $isFirst = true;
?>
<div class="container content-pdf page-break-image" style="padding: 20px">
   <h4 style="font-family: latha, DejaVu Sans, sans-serif;">
      <?php echo (!empty($nameDefect) && $isFirst) ? $nameDefect : false; $isFirst = false; ?></h4>
   <div class="row" style="display: block; margin-top: 50px;">
      <?php
      foreach($listAllImages as $item):
?>
      <div class="col-2 mt-3 mr-2" style="display: inline-block;">
         <img src="<?php echo "data:image/png;base64,".base64_encode(file_get_contents($item['image_link'])) ?>" alt=""
            style="width:200px; height: 200px; object-fit:cover;" class="mr-2 mt-2">
      </div>
      <?php 
      endforeach;
      ?>
   </div>
   <br>
</div>
<?php
   endif;
else:
   if(!empty($listAllImages)): 
      $isFirst = true;
?>
<div class="container">
   <h4><?php echo (!empty($nameDefect) && $isFirst) ? $nameDefect : false; $isFirst = false; ?></h4>
   <div class="row">
      <?php
      foreach($listAllImages as $item):
         ?>
      <div class="col-2">
         <img src="<?php echo $item['image_link'] ?>" alt="" style="width:100%; object-fit: cover" class="mr-2 mt-2">
      </div>
      <?php
      endforeach;
      ?>
      <br>
   </div>
</div>
<?php
   else:
?>
<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <div class="alert alert-danger">Không có ảnh</div>
      </div>
   </div>
</div>
<?php
   endif;
endif;
?>
<?php 
   if(empty($actionOld)):
?>
<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <a href="<?php echo getLinkAdmin('reports', 'seen', ['id' => $reportId]) ?>" class="btn btn-success">Quay
            lại</a>
      </div>
   </div>
</div>
<?php 
   endif;
?>
<?php
   if(empty($actionOld)) {
      layout('footer','admin');
   }
?>
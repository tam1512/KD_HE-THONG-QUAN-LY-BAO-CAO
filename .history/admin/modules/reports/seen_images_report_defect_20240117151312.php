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

if(isPost()) {
   echo '<pre>';
   print_r(getBody('post'));
   echo '</pre>';
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
               ?>
         <div class="d-flex">
            <?php
               foreach($listFiles as $file):
         ?>
            <img src="<?php echo $file ?>" alt="" style="width:20%" class="mr-2">
            <?php 
               endforeach;
               ?>
         </div>
         <br>
         <hr>
         <?php
            else:
         ?>
         <div class="alert alert-danger">Không có ảnh</div>
         <?php 
            endif;
         ?>
         <?php
            $old = ($reportId == 'null') ? 'add' : 'edit';
         ?>
         <form action="" method="post">
            <div class="form-group">
               <label for="">Ảnh lỗi</label>
               <div class="gallery-images">
                  <?php 
                           if(!empty($listFiles)):
                              foreach($listFiles as $image):
                        ?>
                  <div class="gallery-item mb-2">
                     <div class="row ckfinder-group">
                        <div class="col-9">
                           <input type="text" id="gallery" name="gallery[]" class="form-control image-link"
                              placeholder="Đường dẫn ảnh..." value=<?php echo $image ?>>
                        </div>
                        <div class="col-2">
                           <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
                              ảnh</button>
                        </div>
                        <div class="col-1">
                           <button type="button" class="btn btn-danger btn-block btn-remove-image"><i
                                 class="fa fa-times"></i></button>
                        </div>
                     </div>
                  </div>
                  <?php 
                              endforeach;
                           endif;
                        ?>
               </div>
            </div>
            <div class="form-group">
               <button type="button" class="btn btn-warning btn-small" id="addImage">Thêm ảnh</button>
               <button type="submit" class="btn btn-info btn-small">Chỉnh sửa</button>
            </div>

         </form>
         <a href="<?php echo getLinkAdmin('reports', $old, ['id' => $reportId]) ?>" class="btn btn-success">Quay
            lại</a>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
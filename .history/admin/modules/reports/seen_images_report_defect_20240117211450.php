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

if(isPost()) {
   $body = getBody('post');
   $keyRD = $body['key'];
   $reportId = $body['report_id'];
   $gallerys = !empty(array_filter($body['gallery'])) ? array_filter($body['gallery']) : []];
}


if($reportId == 'null') {
   $listAllReportDefects = getSession("listAllReportDefectsAdd");
} else {
   $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
}


foreach($listAllReportDefects as $key=>$value) {
   if($keyRD == $key) {
      if(!empty($gallerys)) {
         $listAllReportDefects[$key]['files'] = $gallerys;
         if($reportId == 'null') {
            setSession("listAllReportDefectsAdd", $listAllReportDefects);
         } else {
            setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
         }
         setFlashData('msg', 'Chỉnh sửa hình ảnh lỗi '.$value['name']." thành công.");
         setFlashData('msg_type', 'success');
         redirect("admin/?module=reports&action=seen_images_report_defect&report_id=$reportId&key=$key");
         break;
      } else {
         $currentReportDefect = $value;
         break;
      }
   }
}
// echo '<pre>';
// print_r($currentReportDefect);
// echo '</pre>';

$nameDefect = $currentReportDefect['name'];
if(!empty($currentReportDefect['files'])) {
   $listFiles = $currentReportDefect['files'];
}

$listImages = [];

if(!empty($listFiles)) {
   foreach($listFiles as $f) {
      if(!empty($f['link'])) {
         $listImages[] = $f['link'];
      } else {
         $listImages[] = $f;
      }
   }
}


$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
getMsg($msg, $msgType);
 ?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <h4><?php echo $nameDefect ?></h4>
         <?php 
            if(!empty($listImages)):
               ?>
         <div class="row">
            <?php
               foreach($listImages as $file):
         ?>
            <div class="col-2">
               <img src="<?php echo $file ?>" alt="" style="width:100%" class="mr-2 mt-2">
            </div>
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
                           if(!empty($listImages)):
                              foreach($listImages as $image):
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
            <input type="hidden" name="report_id" value="<?php echo $reportId ?>">
            <input type="hidden" name="key" value="<?php echo $keyRD ?>">
            <div class="form-group">
               <button type="button" class="btn btn-warning btn-small" id="addImage">Thêm ảnh</button>
               <button type="submit" class="btn btn-info btn-small">Chỉnh sửa</button>
            </div>

         </form>
         <a href="<?php echo ($reportId != "null") ? getLinkAdmin('reports', $old, ['id' => $reportId]) : getLinkAdmin('reports', $old) ?>"
            class="btn btn-success">Quay
            lại</a>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
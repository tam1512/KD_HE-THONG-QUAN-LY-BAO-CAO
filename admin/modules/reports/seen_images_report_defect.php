<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh danh mục sản phẩm
 */

 if(!isLogin()) {
   redirect("admin/dang-nhap");
 } 

$data = [
   'title' => 'Xem Ảnh Lỗi'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

if(isGet()) {
   $keyRD = getBody('get')['key'];
   $reportId = getBody('get')['id'];

   if(!empty($reportId) && $reportId != 'null') {   
      if(!checkId('reports', $reportId)) {
        require_once _WEB_PATH_ROOT.'/modules/errors/404.php';
        die();
      }
   }
}

if(isPost()) {
   $body = getBody('post');
   $keyRD = $body['key'];
   $reportId = $body['id'];
   $gallerys = !empty($body['gallery']) ? array_filter($body['gallery']) : 'empty';
}


if($reportId == 'null') {
   $listAllReportDefects = getSession("listAllReportDefectsAdd");
} else {
   $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
}


foreach($listAllReportDefects as $key=>$value) {
   if($keyRD == $key) {
      if(!empty($gallerys)) {
         if($gallerys == 'empty') {
            $listAllReportDefects[$key]['files'] = [];
         } else {
            $listAllReportDefects[$key]['files'] = $gallerys;
         }
         if($reportId == 'null') {
            setSession("listAllReportDefectsAdd", $listAllReportDefects);
         } else {
            setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
         }
         setFlashData('msg', 'Chỉnh sửa hình ảnh lỗi '.$value['name']." thành công.");
         setFlashData('msg_type', 'success');
         redirect("admin/bao-cao/xem-anh-loi/id=$reportId?key=$key");
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

<div class="container-fluid">
   <div class="row">
      <div class="col">
         <h4><?php echo $nameDefect ?></h4>
         <?php 
            if(!empty($listImages)):
               ?>
         <div class="row">
            <?php
               foreach($listImages as $file):
         ?>
            <div class="col-lg-2 col-md-3 col-sm4 col-4 ">
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
                        <div class="col-lg-9 col-md-9 col-sm-6 col-6">
                           <input type="text" id="gallery" name="gallery[]" class="form-control image-link"
                              placeholder="Đường dẫn ảnh..." value=<?php echo $image ?>>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                           <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
                              ảnh</button>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-2 col-2 ">
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
            <input type="hidden" name="id" value="<?php echo $reportId ?>">
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
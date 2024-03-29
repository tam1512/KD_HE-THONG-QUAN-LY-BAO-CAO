<?php 
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
   redirect("admin/dang-nhap");
 }
 //Lấy userID
 $userId = isLogin()['user_id'];

   $data = [
      'title' => 'Tổng Quan'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $signText = firstRaw("SELECT sign_text FROM sign WHERE user_id = $userId");

   $countUsers = getRows("SELECT id FROM users");
   $countProducts = getRows("SELECT id FROM products");
   $countFactories = getRows("SELECT id FROM factories");
   $countReports = getRows("SELECT id FROM reports");

   $message = getFlashData('msg');
   $msgType = getFlashData('msg_type');
   if(empty($signText)) {
      setFlashData('msg', 'Chưa có chữ ký vui lòng tạo chữ ký');
      setFlashData('msg_type', 'danger');
   }
?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <?php 
         getMsg($message, $msgType);
      ?>
      <div class="row">
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
               <div class="inner">
                  <h3><?php echo !empty($countProducts) ? $countProducts : 0 ?></h3>

                  <p>Sản Phẩm</p>
               </div>
               <div class="icon">
                  <i class="ion ion-bag"></i>
               </div>
               <a href="<?php echo getLinkAdmin('products') ?>" class="small-box-footer">Xem Thêm <i
                     class="fas fa-arrow-circle-right ml-2"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
               <div class="inner">
                  <h3><?php echo !empty($countFactories) ? $countFactories : 0?></h3>

                  <p>Cơ Sở Gia Công</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
               <a href="<?php echo getLinkAdmin('factories') ?>" class="small-box-footer">Xem Thêm<i
                     class="fas fa-arrow-circle-right ml-2"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
               <div class="inner">
                  <h3><?php echo !empty($countUsers) ? $countUsers : 0 ?></h3>

                  <p>Người Dùng</p>
               </div>
               <div class="icon">
                  <i class="ion ion-person"></i>
               </div>
               <a href="<?php echo getLinkAdmin('users') ?>" class="small-box-footer">Xem Thêm<i
                     class="fas fa-arrow-circle-right ml-2"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
               <div class="inner">
                  <h3><?php echo !empty($countReports) ? $countReports : 0 ?></h3>

                  <p>Biên Bản</p>
               </div>
               <div class="icon">
                  <i class="fa fa-file"></i>
               </div>
               <a href="<?php echo getLinkAdmin('reports') ?>" class="small-box-footer">Xem Thêm<i
                     class="fas fa-arrow-circle-right ml-2"></i></a>
            </div>
         </div>
         <!-- ./col -->
      </div>
      <!-- /.row -->
   </div><!-- /.container-fluid -->
</section>
<?php

   layout('footer', 'admin', $data);
?>
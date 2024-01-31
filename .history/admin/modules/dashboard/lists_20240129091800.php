<?php 
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
   redirect("admin/dang-nhap");
 }
 //Lấy userID
 $userId = $_COOKIE['user_id'];

   $data = [
      'title' => 'Tổng quan'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $signText = firstRaw("SELECT sign_text FROM sign WHERE user_id = $userId");

   $countUsers = getRows("SELECT * id FROM users");
   $countProducts = getRows("SELECT * id FROM products");
   $countFactories = getRows("SELECT * id FROM factories");
   $countReports = getRows("SELECT * id FROM reports");

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
               <a href="#" class="small-box-footer">Xem Thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
               <div class="inner">
                  <h3><?php echo !empty($countFactories) ?></h3>

                  <p>Bounce Rate</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
               <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
               <div class="inner">
                  <h3>44</h3>

                  <p>User Registrations</p>
               </div>
               <div class="icon">
                  <i class="ion ion-person-add"></i>
               </div>
               <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
               <div class="inner">
                  <h3>65</h3>

                  <p>Unique Visitors</p>
               </div>
               <div class="icon">
                  <i class="ion ion-pie-graph"></i>
               </div>
               <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
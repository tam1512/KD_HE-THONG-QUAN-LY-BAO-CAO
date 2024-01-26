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
                  <h3>150</h3>

                  <p>New Orders</p>
               </div>
               <div class="icon">
                  <i class="ion ion-bag"></i>
               </div>
               <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
               <div class="inner">
                  <h3>53<sup style="font-size: 20px">%</sup></h3>

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
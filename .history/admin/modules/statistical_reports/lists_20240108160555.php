<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$permissionData = getPermissionData($groupId);
$checkPermission = checkPermission($permissionData, 'statistical_reports', 'lists');

$isExport = checkPermission($permissionData, 'statistical_reports', 'export');

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Báo cáo thống kê');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

 $data = [
  'title' => 'Báo cáo thống kê'
 ];
 layout('header', 'admin', $data);
 layout('sidebar', 'admin', $data);
 layout('breadcrumb', 'admin', $data);

$listAllCates = getRaw("SELECT id, name FROM product_categories");
$listAllFactories = getRaw("SELECT id, name FROM factories");
$yearAllReport = getRaw("SELECT DISTINCT YEAR(create_at) AS year FROM reports ORDER BY year ASC");
$listMonth = [1,2,3,4,5,6,7,8,9,10,11,12];
$currentYear = date("Y");
$minYearCreatReport = null;
$maxYearCreatReport = null;
$listYear = [];
if(!empty($yearAllReport)) {
   foreach($yearAllReport as $item) {
      $listYear[] = $item['year'];
   }
}
// Xử lý dữ liệu cho biểu đồ
$filter = '';
if(isPost()) {
   $body = getBody('post');
   $errors = [];

   // set filter khi có dữ liệu
   if(!empty($body["type_time"])) {
      $type = $body["type_time"];
   }

   if(!empty($body["year"])) {
      $year = trim($body["year"]);
      
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      if(!empty($type) && $type == 2) {
         $filter .= " $operator YEAR(create_at) = $year";   
      }
   }

   if(!empty($body["month"])) {
      $month = trim($body["month"]);
      
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      if(!empty($type) && !empty($year) && $type == 1) {
         $filter .= " $operator CONCAT(MONTH(create_at), '/', YEAR(create_at)) = '$month/$year'";   
      }
   }

   if(!empty($body["object"])) {
      $facId = trim($body["object"]);
      
      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      if($facId != 'all') {
         $filter .= " $operator factory_id=$facId";   
      }
   }

   //Validate 
   if(empty($type)) {
      $errors['type_time']['required'] = "Chưa chọn loại thời gian";
   }
   if(empty($facId)) {
      $errors['object']['required'] = "Chưa chọn đối tượng";
   }
   if(!empty($type)) {
      if($type == 1) {
         if(empty($month)) {
            $errors['month']['required'] = "Chưa chọn tháng";
         }
         if(empty($year)) {
            $errors['year']['required'] = "Chưa chọn năm";
         }
      } else if($type == 2) {
         if(empty($year)) {
            $errors['year']['required'] = "Chưa chọn năm";
         }
      }
   }

   //Xử lý lỗi
   if(empty($errors)) {
      setFlashData('old', $body);
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu bạn đã chọn!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=statistical_reports");
   }
}


//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=statistical_reports', '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '&'.$queryStr;
   }
} 

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>


<section class="content">
   <div class="container-fluid">
      <?php 
      getMsg($msg, $msgType);
      ?>
      <form action="" method="post">
         <div class="row">
            <div class="col-2">
               <div class="form-group">
                  <select name="type_time" id="type_time" class="form-control">
                     <option value="0">Loại thời gian</option>
                     <option value="1"
                        <?php echo (!empty($old['type_time']) && $old['type_time']==1)? 'selected' : false ?>>
                        Theo tháng
                     </option>
                     <option value="2"
                        <?php echo (!empty($old['type_time']) && $old['type_time']==2)? 'selected' : false ?>>
                        Theo năm
                     </option>
                  </select>
                  <span class="error" id="error-type"></span>
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <select name="object" id="object" class="form-control">
                     <option value="0">
                        Chọn đối tượng
                     </option>
                     <option value="all"
                        <?php echo (!empty($old['object']) && $old['object']=='all')? 'selected' : false ?>>
                        Tất cả
                     </option>
                     <?php 
                  if(!empty($listAllFactories)):
                     foreach($listAllFactories as $fac):
               ?>
                     <option value="<?php echo $fac['id'] ?>"
                        <?php echo (!empty($facId) && $facId==$fac['id'])? 'selected' : false ?>>
                        <?php echo $fac['name'] ?></option>
                     <?php 
                  endforeach;
               endif;
               ?>
                  </select>
                  <span class="error" id="error-object"></span>
               </div>
            </div>
            <div class="col-2">
               <div class="form-group">
                  <select name="month" id="month" class="form-control">
                     <option value="0">Chọn tháng</option>
                     <?php 
                        if(!empty($listMonth)):
                           foreach($listMonth as $m):
                     ?>
                     <option value="<?php echo $m ?>"
                        <?php echo (!empty($old['month']) && $old['month']==$m)? 'selected' : false ?>>
                        <?php echo $m ?>
                     </option>
                     <?php endforeach; endif; ?>
                  </select>
                  <span class="error" id="error-month"></span>
               </div>
            </div>
            <div class="col-2">
               <div class="form-group">
                  <select name="year" id="year" class="form-control">
                     <option value="0">Chọn năm</option>
                     <?php 
                        if(!empty($listYear)):
                           foreach($listYear as $y):
                     ?>
                     <option value="<?php echo $y ?>"
                        <?php echo (!empty($old['year']) && $old['year']==$y)? 'selected' : false ?>>
                        <?php echo $y ?>
                     </option>
                     <?php endforeach; endif; ?>
                  </select>
                  <span class="error" id="error-year"></span>
               </div>
            </div>
            <div class="col-2">
               <button type="submit" class="btn btn-primary" id="btnCreateChart">Tạo biểu đồ</button>
            </div>
         </div>
         <input type="hidden" name="module" value="statistical_reports">
      </form>
      <div id="myChart"></div>
   </div><!-- /.container-fluid -->
</section>
<?php
echo '<hr>';
layout('footer', 'admin');
?>
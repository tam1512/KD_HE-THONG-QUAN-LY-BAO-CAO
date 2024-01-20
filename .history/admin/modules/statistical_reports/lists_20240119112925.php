<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;

if($isRoot) {
  $checkPermission = true;
  $isExport = true;
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'statistical_reports', 'lists');
  $isExport = checkPermission($permissionData, 'statistical_reports', 'export');
}

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
$currentMonth = date("m");
$minYearCreatReport = null;
$maxYearCreatReport = null;
$listYear = [];
if(!empty($yearAllReport)) {
   foreach($yearAllReport as $item) {
      $listYear[] = $item['year'];
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>


<section class="content">
   <div class="container-fluid">
      <?php 
      $isFirst = true;
      getMsg($msg, $msgType);
      ?>
      <form action="" method="post">
         <div class="row">
            <div class="col-2">
               <div class="form-group">
                  <select name="type_time" id="type_time" class="form-control">
                     <option value="0">Loại thời gian</option>
                     <option value="1" <?php echo $isFirst ? "selected" : false ?>>
                        Theo tháng
                     </option>
                     <option value="2">
                        Theo năm
                     </option>
                     <option value="3">
                        Theo năm (12 tháng)
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
                     <option value="all" <?php echo $isFirst ? "selected" : false ?>>
                        Tất cả
                     </option>
                     <?php 
                  if(!empty($listAllFactories)):
                     foreach($listAllFactories as $fac):
               ?>
                     <option value="<?php echo $fac['id'] ?>">
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
                        <?php echo $isFirst && $m == $currentMonth ? "selected" : false ?>>
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
                     <option value="<?php echo $y ?>" <?php echo $isFirst && $y == $currentYear ? "selected" : false ?>>
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
            <div class="col-8 mb-3">
               <div class="form-check d-flex align-item-center">
                  <input class="form-check-input" type="checkbox" id="skip-statistical" checked>
                  <label class="form-check-label ml-2" for="skip-statistical">
                     Bỏ qua các lỗi không tính toán
                  </label>
               </div>
            </div>
         </div>
         <input type="hidden" name="module" value="statistical_reports">
      </form>
      <div class="chartCard">
         <div id="chartBox">
         </div>
      </div>
      <hr>
      <div class="mt-5">
         <h2 class="text-center">Bảng thông tin</h2>
         <form action="<?php echo getLinkAdmin('statistical_reports', 'export') ?>" method="post">
            <input type="hidden" id="dataTableExcel" name="dataTableExcel">
            <button type="submit" class="btn btn-success mb-2" name="btnExportExcelStatistical">Xuất Excel</button>
         </form>
         <form action="<?php echo getLinkAdmin('statistical_reports', 'export_test') ?>" target="_blank" method="post">
            <button type="submit" class="btn btn-danger mb-2" name="btnExportPDFReport">Xuất PDF</button>
         </form>
         <div id="contentTable" class="bg-white">
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>
<?php
echo '<hr>';
layout('footer', 'admin');
?>
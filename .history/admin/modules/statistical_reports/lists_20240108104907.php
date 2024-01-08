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
   foreach($yearAllReport as $year) {
      $listYear[] = $year['year'];
   }
}
// Xử lý dữ liệu cho biểu đồ
$filter = '';
if(isPost()) {
   $body = getBody('post');
   var_dump($year);
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
      if($factId != 'all') {
         $filter .= " $operator factory_id=$factId";   
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
         echo "month: ".$month."<br>";
         echo "year: ".$year;
         
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
 
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu bạn đã chọn!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      // redirect("admin/?module=statistical_reports");
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
echo '<pre>';
print_r($old);
echo '</pre>';
echo '<pre>';
print_r($errors);
echo '</pre>';
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
                  <?php echo form_error('type_time', $errors, '<span class="error">', '</span>') ?>
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <select name="object" class="form-control">
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
                  <?php echo form_error('object', $errors, '<span class="error">', '</span>') ?>
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
                  <?php echo form_error('month', $errors, '<span class="error">', '</span>') ?>
               </div>
            </div>
            <div class="col-2">
               <div class="form-group">
                  <select name="year" class="form-control">
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
                  <?php echo form_error('year', $errors, '<span class="error">', '</span>') ?>
               </div>
            </div>
            <div class="col-2">
               <button type="submit" class="btn btn-primary">Tạo biểu đồ</button>
            </div>
         </div>
         <input type="hidden" name="module" value="statistical_reports">
      </form>

      <table class="table table-bordered">
         <thead>
            <tr>
               <th width="10%">STT</th>
               <th>Tên</th>
               <th>Danh mục</th>
               <?php if($isEdit): ?>
               <th width="10%">Sửa</th>
               <?php endif; if($isDelete): ?>
               <th width="10%">Xóa</th>
               <?php endif;?>
            </tr>
         </thead>
         <tbody>
            <?php 
         if(!empty($listProductOnPage)):
            $count = 0;
            foreach($listProductOnPage as $product):
               $count++;
      ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <a href="<?php echo getLinkAdmin('products', 'edit', ['id' => $product['id']])?>">
                     <?php echo $product['name'] ?>
                  </a>
               </td>
               <td>
                  <?php 
                     foreach($listAllCates as $cate) {
                        echo $cate['id'] == $product['cate_id'] ? $cate['name'] : false;
                     }
                  ?>
               </td>
               <?php if($isEdit): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('products', 'edit', ['id'=> $product['id']]) ?>"
                     class="btn btn-warning btn-sm">
                     <i class="fa fa-edit"></i> Sửa
                  </a>
               </td>
               <?php endif; if($isDelete): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('products', 'delete', ['id'=>$product['id']]) ?>"
                     class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                     <i class="fa fa-trash"></i> Xóa
                  </a>
               </td>
               <?php endif;?>
            </tr>
            <?php endforeach; else: ?>
            <tr>
               <td colspan="5">
                  <div class="alert alert-danger text-center">Không có sản phẩm</div>
               </td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>

      <nav aria-label="Page navigation products">
         <ul class="pagination pagination-sm justify-content-end">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
               <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo _WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$prevPage;
            ?>">
                  Trước
               </a>
            </li>

            <?php 
         if(!empty($numPage)) {
            // Tính toán số phân trang bắt đầu để giới hạn trong limit page
            $begin = $page - 2;
            if($begin < 1) {
               $begin = 1;
            }
            $end = $begin + $limitPagination - 1;
            if($end >= $numPage) {
               $end = $numPage;
               $begin = $end - $limitPagination + 1;
            }

            if($numPage <= $limitPagination) {
               for($i = 1; $i <= $numPage; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            }
         }   
      ?>

            <li class="page-item">
               <a class="page-link" href="
         <?php 
            if($page >= $numPage) {
               $nextPage = 1;
            } else {
               $nextPage = $page + 1;
            }
            echo _WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=products'.$queryStr.'&page='.$numPage;
            ?>">
                  Trang cuối
               </a>
            </li>
         </ul>
      </nav>
   </div><!-- /.container-fluid -->
</section>
<?php
echo '<hr>';
layout('footer', 'admin');
?>
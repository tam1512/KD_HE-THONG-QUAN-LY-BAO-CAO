<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/dang-nhap");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;

if($isRoot) {
  $checkPermission = true;
  
  $isEdit = true;
  $isDelete = true;
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'factories', 'lists');
  
  $isEdit = checkPermission($permissionData, 'factories', 'edit');
  $isDelete = checkPermission($permissionData, 'factories', 'delete');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý cơ sở');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

 $data = [
  'title' => 'Quản lý cơ sở'
 ];
 layout('header', 'admin', $data);
 layout('sidebar', 'admin', $data);
 layout('breadcrumb', 'admin', $data);

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {

   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      $filter .= " $operator name LIKE '%$keyword%'";   
   }
}



// Xử lý phân trang

// Số lượng cơ sở
$countRowFactories = getRows("SELECT id FROM factories $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$factoryOnPage = _ITEM_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowFactories/$factoryOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * factoryOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $factoryOnPage;
$listFactoryOnPage = getRaw("SELECT id, name, create_at FROM factories $filter LIMIT $offset, $factoryOnPage");

//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=factories', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '&'.$queryStr;
   }
} 
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>


<section class="content">
   <div class="container-fluid">
      <?php 
      getMsg($msg, $msgType);
      ?>
      <form action="" method="get">
         <div class="row">
            <div class="col-6">
               <input type="text" class="form-control" name="keyword" placeholder="Từ khóa tìm kiếm..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-3">
               <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
         </div>
         <input type="hidden" name="module" value="factories">
      </form>
      </br>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th width="10%">STT</th>
               <th>Tên</th>
               <?php if($isEdit): ?>
               <th width="10%">Sửa</th>
               <?php endif; if($isDelete): ?>
               <th width="10%">Xóa</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
         if(!empty($listFactoryOnPage)):
            $count = 0;
            foreach($listFactoryOnPage as $factory):
               $count++;
      ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <a href="<?php echo getLinkAdmin('factories', 'edit', ['id' => $factory['id']])?>">
                     <?php echo $factory['name'] ?>
                  </a>
               </td>
               <?php if($isEdit): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('factories', 'edit', ['id'=> $factory['id']]) ?>"
                     class="btn btn-warning btn-sm">
                     <i class="fa fa-edit"></i> Sửa
                  </a>
               </td>
               <?php endif; if($isDelete): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('factories', 'delete', ['id'=>$factory['id']]) ?>"
                     class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                     <i class="fa fa-trash"></i> Xóa
                  </a>
               </td>
               <?php endif; ?>
            </tr>
            <?php endforeach; else: ?>
            <tr>
               <td colspan="4">
                  <div class="alert alert-danger text-center">Không có cơ sở</div>
               </td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>

      <nav aria-label="Page navigation factories">
         <ul class="pagination pagination-sm justify-content-end">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
               <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo _WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=factories'.$queryStr.'&page='.$numPage;
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
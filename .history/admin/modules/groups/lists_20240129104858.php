<?php 
if(!defined('_INCODE')) die('Access denied...');
/**
 * Hiển thị danh sách người dùng, phân trang, tìm kiếm
 */
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
   $isPermission = true;
} else {
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'groups', 'lists');
   $isEdit = checkPermission($permissionData, 'groups', 'edit');
   $isDelete = checkPermission($permissionData, 'groups', 'delete');
   $isPermission = checkPermission($permissionData, 'groups', 'permission');
}


 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Nhóm người dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }

   $data = [
      'title' => 'Danh sách nhóm'
   ];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

   $listAllGroups = getRaw("SELECT * FROM groups ORDER BY create_at DESC");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      $filter .= " WHERE name LIKE '%$keyword%'";   
   }
}


// Xử lý phân trang

// Số lượng user
$countRowUsers = getRows("SELECT id FROM groups $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$groupOnPage = _GROUP_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowUsers/$groupOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * groupOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $groupOnPage;
$listGroupOnPage = getRaw("SELECT id, name, root, create_at FROM groups $filter LIMIT $offset, $groupOnPage");

//Xử lý query String
$queryStr = '?';
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=groups', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '?'.$queryStr.'&';
   } else {
      $queryStr = '?';

   }
} 
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <?php 
         getMsg($msg, $msgType);
      ?>
      <form action="" method="get">
         <div class="row">
            <div class="col-8">
               <input type="text" class="form-control" name="keyword" placeholder="Từ khóa tìm kiếm..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-4">
               <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
         </div>
         <!-- <input type="hidden" name="module" value="groups"> -->
      </form>
      <br>
      <table class="table table-bordered table-responsive text-center">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th>Tên nhóm</th>
               <th>Thời gian</th>
               <?php if($isPermission): ?>
               <th>Phân quyền</th>
               <?php endif; if($isEdit): ?>
               <th>Sửa</th>
               <?php endif; if($isDelete): ?>
               <th>Xóa</th>
               <?php endif;?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listGroupOnPage)):
                  $count = 0;
                  foreach($listGroupOnPage as $group):
                     $count++;
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <div>
                     <a class="text-center"
                        href="<?php echo getLinkAdmin('groups', 'edit', ['id' => $group['id']]) ?>"><?php echo $group["name"] ?><?php echo $group['root'] == 1 ? '<i class="fa fa-check-circle ml-2" aria-hidden="true"></i>' : false ?></a>
                  </div>
               </td>
               <td><?php echo getDateFormat($group["create_at"], 'd/m/Y') ?></td>
               <?php if($isPermission): ?>
               <td class="text-center"><a class="btn btn-success"
                     href="<?php echo getLinkAdmin('groups', 'permission', ['id' => $group['id']]) ?>">Phân quyền</a>
               </td>
               <?php endif; if($isEdit): ?>
               <td class="text-center">
                  <a class="btn btn-warning"
                     href="<?php echo getLinkAdmin('groups', 'edit', ['id' => $group['id']]) ?>"><i
                        class="fa fa-edit"></i></a>
               </td>
               <?php endif; if($isDelete): ?>
               <td class="text-center">
                  <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('groups', 'delete', ['id' => $group['id']]) ?>"><i
                        class="fa fa-trash"></i></a>
               </td>
               <?php endif;?>
            </tr>
            <?php 
               endforeach; else:
            ?>
            <tr>
               <td colspan="6" class="text-center alert-danger">Không có nhóm người dùng</td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <nav aria-label="Page navigation groups"
         class="<?php echo ($numPage == 1 || empty($numPage)) ? 'd-none' : false ?>">
         <ul class="pagination pagination-sm justify-content-end">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
               <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo getLinkAdmin('groups').$queryStr.'page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('groups').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('groups').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('groups').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('groups').$queryStr.'page='.$i.'">'.$i.'</a></li>';
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
            echo getLinkAdmin('groups').$queryStr.'page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo getLinkAdmin('groups').$queryStr.'page='.$numPage;
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
   layout('footer', 'admin', $data);
?>
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
   $isEdit = true;
   $isDelete = true;
   $isExport = true;
   $isSeen = true;
   $isSeenAll = true;
} else {
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'reports', 'lists');
   $isEdit = checkPermission($permissionData, 'reports', 'edit');
   $isDelete = checkPermission($permissionData, 'reports', 'delete');
   $isExport = checkPermission($permissionData, 'reports', 'export');
   $isSeen = checkPermission($permissionData, 'reports', 'seen');
   $isSeenAll = checkPermission($permissionData, 'reports', 'seen_all');
}
 $permissionData = getPermissionData($groupId);
 $checkPermission = checkPermission($permissionData, 'users', 'lists');

 $isEdit = checkPermission($permissionData, 'users', 'edit');
 $isDelete = checkPermission($permissionData, 'users', 'delete');

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý người dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }

 $data = [
  'title' => 'Quản lý người dùng'
 ];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin', $data);
 layout('breadcrumb', 'admin', $data);
 
 // lấy ra user_id
 $user_id = $_COOKIE['user_id'];

 echo '<div class="container"> <br>'; 

$listAllUsers = getRaw("SELECT id, fullname, email, phone, address, group_id FROM users ORDER BY create_at DESC");
$listAllGroups = getRaw("SELECT id, name FROM groups");
// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["status"])) {
      $status = getBody()["status"];
      if($status == 2) {
         $statusSql = 0;
      } else {
         $statusSql = $status;
      }
      $filter .= "WHERE status = $statusSql";
   }

   if(!empty(getBody()["groups"])) {
      $groups = getBody()["groups"];

      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }

      $filter .= " $operator group_id = $groups";
   }

   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      
      if( !empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }
      $filter .= " $operator fullname LIKE '%$keyword%'";   
   }
}



// Xử lý phân trang

// Số lượng user
$countRowUsers = getRows("SELECT id FROM users $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$userOnPage = _USER_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowUsers/$userOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * userOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $userOnPage;
$listUsersOnPage = getRaw("SELECT id,fullname, email, status, group_id FROM users $filter LIMIT $offset, $userOnPage");

//Xử lý query String
$queryStr = null;
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=users', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '&'.$queryStr;
   }
} 
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<hr />
<?php 
   getMsg($msg, $msgType);
?>
<form action="" method="get">
   <div class="row">
      <div class="col-2">
         <div class="form-group">
            <select name="status" class="form-control">
               <option value="0">Chọn trạng thái</option>
               <option value="1" <?php echo (!empty($status) && $status==1)? 'selected' : false ?>>Kích hoạt</option>
               <option value="2" <?php echo (!empty($status) && $status==2)? 'selected' : false ?>>Chưa kích hoạt
               </option>
            </select>
         </div>
      </div>
      <div class="col-2">
         <div class="form-group">
            <select name="groups" class="form-control">
               <option value="0">Chọn nhóm</option>
               <?php 
                  if(!empty($listAllGroups)):
                     foreach($listAllGroups as $group):
               ?>
               <option value="<?php echo $group['id'] ?>"
                  <?php echo (!empty($groups) && $groups==$group['id'])? 'selected' : false ?>>
                  <?php echo $group['name'] ?></option>
               <?php 
                  endforeach;
               endif;
               ?>
            </select>
         </div>
      </div>
      <div class="col-6">
         <input type="text" class="form-control" name="keyword" placeholder="Từ khóa tìm kiếm..."
            value="<?php echo !empty($keyword) ? $keyword : false ?>">
      </div>
      <div class="col-2">
         <button type="submit" class="btn btn-primary">Tìm kiếm</button>
      </div>
   </div>
   <input type="hidden" name="module" value="users">
</form>

<table class="table table-bordered">
   <thead>
      <tr>
         <th width="5%">STT</th>
         <th>Họ Tên</th>
         <th>Email</th>
         <th>Nhóm người dùng</th>
         <th>Trạng Thái</th>
         <?php if($isEdit): ?>
         <th width="5%">Sửa</th>
         <?php endif; if($isDelete): ?>
         <th width="5%">Xóa</th>
         <?php endif;?>
      </tr>
   </thead>
   <tbody>
      <?php 
         if(!empty($listUsersOnPage)):
            $count = 0;
            foreach($listUsersOnPage as $user):
               $count++;
      ?>
      <tr>
         <td><?php echo $count ?></td>
         <td><a
               href="<?php echo getLinkAdmin('users', 'edit', ['id' => $user['id']])?>"><?php echo $user['fullname'] ?></a>
         </td>
         <td><?php echo $user['email'] ?></td>
         <td>
            <?php 
               foreach($listAllGroups as $group) {
                  echo $group['id'] == $user['group_id'] ? $group['name'] : false;
               }
            ?>
         </td>
         <td>
            <?php echo $user['status'] == 1 ? '<button type="button" class="btn btn-success btn-sm">Kích hoạt</button>' : '<button type="button" class="btn btn-warning btn-sm">Chưa kích hoạt</button>' ?>
         </td>
         <?php if($isEdit): ?>
         <td>
            <a href="<?php echo getLinkAdmin('users', 'edit', ['id'=> $user['id']]) ?>" class="btn btn-warning btn-sm">
               <i class="fa fa-edit"></i>
            </a>
         </td>
         <?php endif; if($isDelete): ?>
         <td>
            <a href="<?php echo getLinkAdmin('users', 'delete', ['id'=>$user['id']]) ?>" class="btn btn-danger btn-sm"
               onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
               <i class="fa fa-trash"></i>
            </a>
         </td>
         <?php endif;?>
      </tr>
      <?php endforeach; else: ?>
      <tr>
         <td colspan="7">
            <div class="alert alert-danger text-center">Không có người dùng</div>
         </td>
      </tr>
      <?php endif; ?>
   </tbody>
</table>

<nav aria-label="Page navigation users">
   <ul class="pagination pagination-sm justify-content-end">
      <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
         <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo _WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$i.'">'.$i.'</a></li>';
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
            echo _WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$nextPage;
         ?>">
            Sau
         </a>
      </li>
      <li class="page-item">
         <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo _WEB_HOST_ROOT_ADMIN.'?module=users'.$queryStr.'&page='.$numPage;
            ?>">
            Trang cuối
         </a>
      </li>
   </ul>
</nav>
<hr>
<?php
echo "</div>";
layout('footer', 'admin');
?>
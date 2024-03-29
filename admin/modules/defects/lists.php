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
  $checkPermission = checkPermission($permissionData, 'defects', 'lists');
  $isEdit = checkPermission($permissionData, 'defects', 'edit');
  $isDelete = checkPermission($permissionData, 'defects', 'delete');
}  


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý lỗi');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

 $data = [
  'title' => 'Quản Lý Lỗi'
 ];
 layout('header', 'admin', $data);
 layout('sidebar', 'admin', $data);
 layout('breadcrumb', 'admin', $data);

$listAllCates = getRaw("SELECT id, name FROM defect_categories");
// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["cate_id"])) {
      $cateId = getBody()["cate_id"];

      if(!empty($filter) && strpos($filter, "WHERE") >= 0) {
         $operator = 'AND';
      } else {
         $operator = 'WHERE';
      }

      $filter .= " $operator cate_id = $cateId";
   }

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

// Số lượng lỗi
$countRowDefects = getRows("SELECT id FROM defects $filter");
// Số lượng lỗi muốn hiển thị trên 1 trang
$defectOnPage = _ITEM_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowDefects/$defectOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * defectOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $defectOnPage;
$listDefectOnPage = getRaw("SELECT id, name, level, cate_id, create_at FROM defects $filter LIMIT $offset, $defectOnPage");

//Xử lý query String
$queryStr = '?';
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=defects', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '?'.$queryStr.'&';
   }else {
      $queryStr = '?';
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
         <div class="row mb-3">
            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
               <div class="form-group">
                  <select name="cate_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Danh mục lỗi" data-width="100%">
                     <option value="0">Chọn danh mục</option>
                     <?php 
                  if(!empty($listAllCates)):
                     foreach($listAllCates as $cate):
               ?>
                     <option value="<?php echo $cate['id'] ?>"
                        <?php echo (!empty($cateId) && $cateId==$cate['id'])? 'selected' : false ?>>
                        <?php echo $cate['name'] ?></option>
                     <?php 
                  endforeach;
               endif;
               ?>
                  </select>
               </div>
            </div>
            <div class="col-8 col-sm-8 col-md-6 col-lg-6">
               <input type="text" class="form-control" name="keyword" placeholder="Từ khóa tìm kiếm..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-4 col-sm-4 col-md-2 col-lg-2">
               <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
         </div>
      </form>

      <table class="table table-bordered table-responsive">
         <thead>
            <tr>
               <th width="10%">STT</th>
               <th width="100%">Tên</th>
               <th width="20%">Mức độ</th>
               <th width="20%">Danh mục</th>
               <?php if($isEdit): ?>
               <th width="10%">Sửa</th>
               <?php endif; if($isDelete): ?>
               <th width="10%">Xóa</th>
               <?php endif; ?>
            </tr>
         </thead>
         <tbody>
            <?php 
         if(!empty($listDefectOnPage)):
            $count = 0;
            foreach($listDefectOnPage as $defect):
               $count++;
      ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <a href="<?php echo getLinkAdmin('defects', 'edit', ['id' => $defect['id']]).'?page='.$page?>">
                     <?php echo $defect['name'] ?>
                  </a>
               </td>
               <td>
                  <?php 
                     echo getLevelString($defect['level']);  
                  ?>
               </td>
               <td>
                  <?php 
                     foreach($listAllCates as $cate) {
                        echo $cate['id'] == $defect['cate_id'] ? $cate['name'] : false;
                     }
                  ?>
               </td>
               <?php if($isEdit): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('defects', 'edit', ['id'=> $defect['id']]).'?page='.$page ?>"
                     class="btn btn-warning btn-sm">
                     <i class="fa fa-edit"></i>
                  </a>
               </td>
               <?php endif; if($isDelete): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('defects', 'delete', ['id'=>$defect['id']]).'?page='.$page ?>"
                     class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                     <i class="fa fa-trash"></i>
                  </a>
               </td>
               <?php endif ?>
            </tr>
            <?php endforeach; else: ?>
            <tr>
               <td colspan="6">
                  <div class="alert alert-danger text-center">Không có lỗi</div>
               </td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>

      <nav aria-label="Page navigation defects"
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
               echo getLinkAdmin('defects').$queryStr.'page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('defects').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('defects').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('defects').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('defects').$queryStr.'page='.$i.'">'.$i.'</a></li>';
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
            echo getLinkAdmin('defects').$queryStr.'page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo getLinkAdmin('defects').$queryStr.'page='.$numPage;
            ?>">
                  Trang cuối
               </a>
            </li>
         </ul>
      </nav>
   </div><!-- /.container-fluid -->
</section>
<?php
layout('footer', 'admin');
?>
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
  $checkPermission = checkPermission($permissionData, 'products', 'lists');
  $isEdit = checkPermission($permissionData, 'products', 'edit');
  $isDelete = checkPermission($permissionData, 'products', 'delete');
}  


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý sản phẩm');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

 $data = [
  'title' => 'Quản Lý Sản Phẩm'
 ];
 layout('header', 'admin', $data);
 layout('sidebar', 'admin', $data);
 layout('breadcrumb', 'admin', $data);

$listAllCates = getRaw("SELECT id, name FROM product_categories");
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
      $filter .= " $operator fullname LIKE '%$keyword%'";   
   }
}



// Xử lý phân trang

// Số lượng user
$countRowProducts = getRows("SELECT id FROM products $filter");

// Số lượng người dùng muốn hiển thị trên 1 trang
$productOnPage = _ITEM_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowProducts/$productOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * productOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $productOnPage;
$listProductOnPage = getRaw("SELECT id, name, cate_id, create_at FROM products $filter LIMIT $offset, $productOnPage");

//Xử lý query String
$queryStr = '?';
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=products', '', $queryStr);
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
         <div class="row mb-5">
            <div class="col-12 col-sm-12 col-md-3 col-lg-2">
               <div class="form-group">
                  <select name="cate_id" class="form-control">
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
            <div class="col-8 col-sm-8 col-md-7 col-lg-8">
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
               <th width="50%">Tên</th>
               <th width="25%">Danh mục</th>
               <th width="20%">Thời gian</th>
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
               <td><?php echo getDateFormat($product["create_at"], 'd/m/Y') ?></td>
               <?php if($isEdit): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('products', 'edit', ['id'=> $product['id']]) ?>"
                     class="btn btn-warning btn-sm">
                     <i class="fa fa-edit"></i>
                  </a>
               </td>
               <?php endif; if($isDelete): ?>
               <td>
                  <a href="<?php echo getLinkAdmin('products', 'delete', ['id'=>$product['id']]) ?>"
                     class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                     <i class="fa fa-trash"></i>
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

      <nav aria-label="Page navigation products"
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
               echo getLinkAdmin('product').$queryStr.'page='.$prevPage;
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
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('product').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('product').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('product').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('product').$queryStr.'page='.$i.'">'.$i.'</a></li>';
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
            echo getLinkAdmin('product').$queryStr.'page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo getLinkAdmin('product').$queryStr.'page='.$numPage;
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
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
} else {
  $permissionData = getPermissionData($groupId);
  $checkPermission = checkPermission($permissionData, 'products', 'edit');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Sửa sản phẩm');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Chỉnh sửa sản phẩm'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

$listAllCates = getRaw("SELECT id, name FROM product_categories");

if(isGet()) {
   $productId = trim(getBody()['id']);
   
   if(!empty($productId)) {
      $defaultProduct = firstRaw("SELECT name, cate_id FROM products WHERE id = '$productId'");
      setFlashData('defaultProduct', $defaultProduct);
   } else {
      redirect("admin/san-pham");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $productId = trim($body['id']);
   $cateId = trim(getBody()['cate_id']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên sản phẩm không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'cate_id' => $cateId,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('products', $dataUpdate, "id=$productId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa sản phẩm thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/san-pham');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/san-pham/chinh-sua/id=$productId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultProduct = getFlashData('defaultProduct');
if(!empty($defaultProduct)) {
   $old = $defaultProduct;
}
 ?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="name">Tên sản phẩm</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="cate_id">Danh mục sản phẩm</label>
                     <select name="cate_id" class="form-control">
                        <?php 
                           if(!empty($listAllCates)):
                              foreach($listAllCates as $cate):
                        ?>
                        <option value="<?php echo $cate['id'] ?>"
                           <?php echo (!empty($old['cate_id']) && $old['cate_id']==$cate['id'])? 'selected' : false ?>>
                           <?php echo $cate['name'] ?></option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $productId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa</button>
            <a href="<?php echo getLinkAdmin('products') ?>" class="btn btn-success" type="submit">Quay
               lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
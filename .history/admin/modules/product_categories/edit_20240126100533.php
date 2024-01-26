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
  $checkPermission = checkPermission($permissionData, 'product_categories', 'edit');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Sửa danh mục sản phẩm');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

$data = [
   'title' => 'Chỉnh sửa danh mục'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

if(isGet()) {
   $cateId = trim(getBody()['id']);
   
   if(!empty($cateId)) {
      $defaultCate = firstRaw("SELECT name FROM product_categories WHERE id = '$cateId'");
      setFlashData('defaultCate', $defaultCate);
   } else {
      redirect("admin/danh-muc-san-pham");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $cateId = trim($body['id']);
   if(empty($name)) {
      $errors['name']['required'] = 'Tên danh mục không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('product_categories', $dataUpdate, "id=$cateId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa danh mục sản phẩm thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/danh-muc-san-pham');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/danh-muc-san-pham/chinh-sua/id=$cateId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultCate = getFlashData('defaultCate');
if(!empty($defaultCate)) {
   $old = $defaultCate;
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
                     <label for="name">Tên danh mục</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $cateId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa</button>
            <a href="<?php echo getLinkAdmin('product_categories') ?>" class="btn btn-success" type="submit">Quay
               lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
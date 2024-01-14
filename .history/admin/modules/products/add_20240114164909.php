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
} else {
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'products', 'add');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Thêm sản phẩm');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Thêm sản phẩm'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

$listAllCates = getRaw("SELECT id, name FROM product_categories");

if(isPost()) {
   $errors = [];
   $body = getBody();
   $name = trim($body['name']);
   $cateId = trim($body['cate_id']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên sản phẩm không được để trống';
   }
   
   if(empty($errors)) {
      $dataInsert = [
         'name' => $name,
         'cate_id' => $cateId,
         'create_at' => date('Y-m-d H:i:s')
      ];

      $insertStatus = insert('products', $dataInsert);
      if($insertStatus) {
         setFlashData('msg', 'Thêm sản phẩm thành công.');
         setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
          setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=products');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=products&action=add');
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<hr>
<div class="container">
   <?php getMsg($message, $msgType) ?>
   <form action="" method="POST">
      <div class="row">
         <div class="col-6">
            <div class="form-group">
               <label for="name">Tên sản phẩm:</label>
               <input type="text" id="name" name="name" class="form-control" placeholder="Tên sản phẩm..."
                  value="<?php echo form_infor('name', $old) ?>">
               <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-6">
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
         </div>
      </div>
      <button type="submit" class="btn btn-primary btn-lg">Thêm</a>
   </form>
</div>
<hr>
<?php
  layout('footer', 'admin');
 ?>
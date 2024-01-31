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
  $checkPermission = checkPermission($permissionData, 'factories', 'edit');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Sửa cơ sở');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Chỉnh Sửa Cơ Sở'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

if(isGet()) {
   $factoryId = trim(getBody()['id']);
   
   if(!empty($factoryId)) {
      $defaultFactory = firstRaw("SELECT name FROM factories WHERE id = '$factoryId'");
      setFlashData('defaultFactory', $defaultFactory);
   } else {
      redirect("admin/co-so");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $factoryId = trim($body['id']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên cơ sở không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('factories', $dataUpdate, "id=$factoryId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa cơ sở thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/co-so');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/co-so/chinh-sua/id=$factoryId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultFactory = getFlashData('defaultFactory');
if(!empty($defaultFactory)) {
   $old = $defaultFactory;
}
 ?>

<div class="container">
   <div class="row">
      <div class="col">
         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="name">Tên cơ sở</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $factoryId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa</button>
            <a href="<?php echo getLinkAdmin('factories') ?>" class="btn btn-success" type="submit">Quay
               lại</a>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
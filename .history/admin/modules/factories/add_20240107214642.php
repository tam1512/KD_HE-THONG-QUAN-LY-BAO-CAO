<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$permissionData = getPermissionData($groupId);
$checkPermission = checkPermission($permissionData, 'factories', 'add');

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý cơ sở');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Thêm cở sở'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

if(isPost()) {
   $errors = [];
   $body = getBody();
   $name = trim($body['name']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên cở sở không được để trống';
   }
   
   if(empty($errors)) {
      $dataInsert = [
         'name' => $name,
         'create_at' => date('Y-m-d H:i:s')
      ];

      $insertStatus = insert('factories', $dataInsert);
      if($insertStatus) {
         setFlashData('msg', 'Thêm cở sở thành công.');
         setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
          setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=factories');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=factories&action=add');
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
         <div class="col">
            <div class="form-group">
               <label for="name">Tên cở sở:</label>
               <input type="text" id="name" name="name" class="form-control" placeholder="Tên cở sở..."
                  value="<?php echo form_infor('name', $old) ?>">
               <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
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
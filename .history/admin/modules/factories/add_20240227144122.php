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
  $checkPermission = checkPermission($permissionData, 'factories', 'add');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Thêm cơ sở');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Thêm Cở Sở'
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
      redirect('admin/co-so');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/co-so/them');
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<div class="container-fluid">
   <?php getMsg($message, $msgType) ?>
   <form action="" method="POST">
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label for="name">Tên cở sở:<span style="color:red">*</span></label>
               <input type="text" id="name" name="name" class="form-control" placeholder="Tên cở sở..."
                  value="<?php echo form_infor('name', $old) ?>">
               <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
      </div>
      <button type="submit" class="btn btn-primary">Thêm</a>
   </form>
</div>
<?php
  layout('footer', 'admin');
 ?>
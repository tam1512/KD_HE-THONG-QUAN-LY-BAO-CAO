<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa người dùng
 */
$data = [
   'title' => 'Chỉnh sửa tài khoản'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý đăng ký

if(isGet()) {
   $groupId = trim(getBody()['id']);
   
   if(!empty($groupId)) {
      $defaultGroup = firstRaw("SELECT name, permission FROM groups WHERE id = '$groupId'");
      setFlashData('defaultGroup', $defaultGroup);
   } else {
      redirect("admin/?module=groups");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $permission = trim($body['permission']);
   $groupId = trim($body['id']);
   if(empty($name)) {
      $errors['name']['required'] = 'Nhóm người dùng không được để trống';
   }

   if(empty($permission)) {
      $errors['permission']['required'] = 'Phân quyền không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'permission' => $permission,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('groups', $dataUpdate, "id=$groupId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa nhóm người dùng thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=groups');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=groups&action=edit&id=$groupId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultGroup = getFlashData('defaultGroup');
if(!empty($defaultGroup)) {
   $old = $defaultGroup;
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
                     <label for="name">Tên nhóm người dùng</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên nhóm người dùng..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="permission">Phân quyền</label>
                     <input type="text" id="permission" name="permission" class="form-control"
                        placeholder="Phân quyền..." value="<?php echo old('permission', $old) ?>">
                     <?php echo form_error('permission', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $groupId ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa</button>
            <a href="<?php echo getLinkAdmin('groups') ?>" class="btn btn-success" type="submit">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
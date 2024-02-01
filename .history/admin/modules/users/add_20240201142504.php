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
  $checkPermission = checkPermission($permissionData, 'users', 'edit');
}

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Thêm Người Dùng');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

$data = [
   'title' => 'Thêm Người Dùng'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

$listAllGroups = getRaw("SELECT id, name FROM groups");

if(isPost()) {
   $errors = [];
   $body = getBody();
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $password = trim($body['password']);
   $confirmPassword = trim($body['confirm_password']);
   $status = trim($body['status']);
   $permission = trim($body['groups']);
   $phone = trim($body['phone']);
   $address = trim($body['address']);


   if(empty($fullname)) {
      $errors['fullname']['required'] = 'Họ tên không được để trống';
   }

   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else {
      if(!isEmail($email)) {
         $errors['email']['invalid'] = 'Địa chỉ email không đúng. Vui lòng nhập lại';
      }
   }

   if(empty($password)) {
      $errors['password']['required'] = 'Mật khẩu không được để trống';
   } else {
      if(strlen($password) < 8) {
         $errors['password']['min'] = 'Mật khẩu phải dài hơn 8 ký tự';
      }
   }

   if(!empty($password)) {
      if(empty($confirmPassword)) {
         $errors['confirm_password']['required'] = 'Nhập lại mật khẩu không được để trống';
      } else {
         if($password != $confirmPassword) {
            $errors['confirm_password']['match'] = 'Mật khẩu không trùng khớp';
         }
      }
   }


   if(empty($errors)) {
      $dataInsert = [
         'fullname' => $fullname,
         'email' => $email,
         'status' => $status,
         'group_id' => $permission,
         'phone' => $phone,
         'address' => $address,
         'password' => password_hash($password, PASSWORD_DEFAULT),
         'create_at' => date('Y-m-d H:i:s')
      ];

      $insertStatus = insert('users', $dataInsert);
      if($insertStatus) {
         setFlashData('msg', 'Thêm tài khoản thành công.');
         setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
          setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/nguoi-dung');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/nguoi-dung/them');
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
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="fullname">Họ tên:</label>
               <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Họ tên..."
                  value="<?php echo form_infor('fullname', $old) ?>">
               <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="text" id="email" name="email" class="form-control" placeholder="Email..."
                  value="<?php echo form_infor('email', $old) ?>">
               <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="status">Trạng thái</label>
               <select name="status" class="form-control">
                  <option value="0" <?php echo (!empty($old['status']) && $old['status']==0)? 'selected' : false ?>>
                     Chưa kích hoạt
                  <option value="1" <?php echo (!empty($old['status']) && $old['status']==1)? 'selected' : false ?>>
                     Kích hoạt</option>
                  </option>
               </select>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="groups">Nhóm quyền</label>
               <select name="groups" class="form-control">
                  <?php 
                  if(!empty($listAllGroups)):
                     foreach($listAllGroups as $group):
               ?>
                  <option value="<?php echo $group['id'] ?>"
                     <?php echo (!empty($old['group_id']) && $old['group_id']==$group['id'])? 'selected' : false ?>>
                     <?php echo $group['name'] ?></option>
                  <?php 
                  endforeach;
               endif;
               ?>
               </select>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="phone">Số điện thoại</label>
               <input type="text" id="phone" name="phone" class="form-control" placeholder="Số điện thoại..."
                  value="<?php echo form_infor('phone', $old) ?>">
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="address">Địa chỉ</label>
               <input type="text" id="address" name="address" class="form-control" placeholder="Địa chỉ..."
                  value="<?php echo form_infor('address', $old) ?>">
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="password">Mật khẩu</label>
               <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu...">
               <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
               <label for="confirm_password">Nhập lại mật khẩu</label>
               <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                  placeholder="Nhập lại mật khẩu...">
               <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
      </div>
      <button type="submit" class="btn btn-primary">Thêm</a>
   </form>
</div>
<?php
  layout('footer', 'admin');
 ?>
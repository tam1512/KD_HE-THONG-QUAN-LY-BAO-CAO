<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng hiển thị thông tin người dùng
 */
$data = [
   'title' => 'Thông tin người dùng'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

$userId = isLogin()["user_id"];
$userDetail = firstRaw("SELECT fullname, email, phone, address, name_avatar  FROM users WHERE id = $userId");

if(isPost()) {
   $errors = [];
   $body = getBody();
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $phone = trim($body['phone']);
   $address = trim($body['address']);
   $avatar = null;
   $avatarPath = null;
   $config = [
      'upload_dir' => "\modules\\users\uploads",
      'max_size' => 5242880,
      'allowed' => 'html, htm, txt, jpg, jpeg, png, gif, pdf, mp3, wav, sql',
      'change_file_name' => uniqid()
   ];
   $data = uploadFile($config,'avatar', $_FILES['avatar']);

   if($data['status'] == 'success') {
      $avatar = $data['link'];
      $avatarPath = $data['path'];
   }

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

   if(empty($errors)) {
      $dataUpdate = [
         'fullname' => $fullname,
         'email' => $email,
         'phone' => $phone,
         'address' => $address,
         'avatar' => $avatar,
         'path_avatar' => $avatarPath,
         'update_at' => date('Y-m-d H:i:s')
      ];

      $updateStatus = update('users', $dataUpdate, "id = $userId");
      if($updateStatus) {
         setFlashData('msg', 'Chỉnh sửa thông tin tài khoản thành công.');
         setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
          setFlashData('msg_type', 'danger'); 
      }
      redirect('admin');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=users&action=profile');
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$infor = $userDetail;
if(!empty($old)) {
   $infor = $old;
} 
?>
<hr>
<div class="container">
   <?php getMsg($message, $msgType) ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <div class="row">
         <div class="col-6">
            <div class="form-group">
               <label for="fullname">Họ tên:</label>
               <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Họ tên..."
                  value="<?php echo form_infor('fullname', $infor) ?>">
               <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="text" id="email" name="email" class="form-control" placeholder="Email..."
                  value="<?php echo form_infor('email', $infor) ?>">
               <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="phone">Số điện thoại</label>
               <input type="text" id="phone" name="phone" class="form-control" placeholder="Số điện thoại..."
                  value="<?php echo form_infor('phone', $infor) ?>">
            </div>
         </div>
         <div class="col-6">
            <div class="form-group">
               <label for="address">Địa chỉ</label>
               <input type="text" id="address" name="address" class="form-control" placeholder="Địa chỉ..."
                  value="<?php echo form_infor('address', $infor) ?>">
            </div>
         </div>
         <div class="col-12">
            <div class="form-group">
               <label for="avatar">Ảnh đại diện</label>
               <input type="file" id="avatar" name="avatar" class="form-control">
            </div>
         </div>
         <input type="hidden" name="path" id="path" value="<?php echo form_infor('path_avatar', $infor) ?>">
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Chỉnh sửa</a>
   </form>
</div>
<hr>
<?php
  layout('footer', 'admin');
 ?>
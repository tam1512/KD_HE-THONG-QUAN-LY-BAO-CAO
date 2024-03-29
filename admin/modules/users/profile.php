<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng hiển thị thông tin người dùng
 */
if(!isLogin()) {
   redirect("admin/dang-nhap");
 }
 
$data = [
   'title' => 'Thông Tin Người Dùng'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

$userId = isLogin()["user_id"];
$userDetail = firstRaw("SELECT fullname, email, phone, address, avatar  FROM users WHERE id = $userId");

if(isPost()) {
   $errors = [];
   $body = getBody();
   $fullname = trim($body['fullname']);
   $email = trim($body['email']);
   $phone = trim($body['phone']);
   $address = trim($body['address']);
   $avatar = !empty($body['avatar']) ? $body['avatar'] : $userDetail['avatar'];
   $config = [
      'upload_dir' => "/modules/users/uploads",
      'max_size' => 5242880,
      'allowed' => 'html, htm, txt, jpg, jpeg, png, gif, pdf, mp3, wav, sql',
      'change_file_name' => uniqid()
   ];
   $data = uploadFile($config,'avatar', $_FILES['avatar']);

   if($data['status'] == 'success') {
      $avatar = $data['link'];
      $avatarName = $data['fileOr'];
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
      redirect('admin/nguoi-dung/thong-tin-ca-nhan');
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
<div class="container-fluid">
   <?php getMsg($message, $msgType) ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <div class="row">
         <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group">
               <label for="fullname">Họ tên:<span style="color:red">*</span></label>
               <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Họ tên..."
                  value="<?php echo form_infor('fullname', $infor) ?>">
               <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group">
               <label for="email">Email:<span style="color:red">*</span></label>
               <input type="text" id="email" name="email" class="form-control" placeholder="Email..."
                  value="<?php echo form_infor('email', $infor) ?>">
               <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
            </div>
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group">
               <label for="phone">Số điện thoại</label>
               <input type="text" id="phone" name="phone" class="form-control" placeholder="Số điện thoại..."
                  value="<?php echo form_infor('phone', $infor) ?>">
            </div>
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group">
               <label for="address">Địa chỉ</label>
               <input type="text" id="address" name="address" class="form-control" placeholder="Địa chỉ..."
                  value="<?php echo form_infor('address', $infor) ?>">
            </div>
         </div>
         <div class="col-12">
            <div class="form-group">
               <label for="avatar">Ảnh đại diện</label>
               <div class="form-control">
                  <input type="file" id="avatar" name="avatar">
                  <!-- <label for=""><?php echo form_infor('name_avatar', $infor) ?></label> -->
               </div>
            </div>
         </div>
      </div>
      <button type="submit" class="btn btn-primary">Lưu</a>
   </form>
</div>
<?php
  layout('footer', 'admin');
 ?>
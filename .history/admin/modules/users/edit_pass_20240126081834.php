<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa mật khẩu của người dùng đang đăng nhập
 */
$data = [
   'title' => 'Đổi mật khẩu'
];

 layout('header','admin',$data);
 layout('sidebar','admin');
 layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 $userId = isLogin()["user_id"];
 $queryUser = firstRaw("SELECT password, fullname, email FROM users WHERE id = $userId");
 $pass_old = $queryUser['password'];
 $fullname = $queryUser['fullname'];
 $email = $queryUser['email'];
 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $password_old = trim($body['password_old']);
   $password = trim($body['password']);
   $confirm_password = trim($body['confirm_password']);

   // validate password old
   if(empty($password_old)) {
      $errors['password_old']['empty'] = 'Mật khẩu củ không được để trống';
   } else {
      if(!password_verify($password_old, $pass_old)) {
         $errors['password_old']['match'] = 'Mật khẩu không đúng.';
      }
   }

   // validate password new
   if(empty($password)) {
      $errors['password']['empty'] = 'Mật khẩu mới không được để trống';
   } else if (strlen($password) < 8) {
      $errors['password']['min'] = 'Mật khẩu mới tối thiểu phải có 8 ký tự';
   } 

   // Validate nhập lại mật khẩu: bắt buộc nhập, trùng với mật khẩu
   if(empty($confirm_password)) {
      $errors['confirm_password']['required'] = 'Nhập lại mật khẩu mới không được để trống';
   } else if ($password !== $confirm_password)  {
      $errors['confirm_password']['match'] = 'Mật khẩu không trùng khớp';
   }
   
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'password' =>  password_hash($password, PASSWORD_DEFAULT),
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('users', $dataUpdate, "id=$userId");
      if($updateStatus) {
           

            //send Mail 
            $subject = 'Chúc mừng '.$fullname. ' đổi mật khẩu thành công<br> <br>';
            $content= 'Chúc mừng bạn đã đổi mật khẩu thành công. Hiện tại bạn có thể đăng nhập với mật khẩu mới.<br> <br>';
            $content.= 'Nếu không phải bạn thay đổi, vui lòng liên hệ ngay với chúng tôi.<br> <br>';
            $content.= 'Trân trọng';

            //Gửi mail
            $sendMail = sendMail($email, $subject, $content);
            
            setFlashData('msg', 'Đổi mật khẩu thành công. Giờ bạn có thể đăng nhập với mật khẩu mới');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=auth&action=logout');
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      redirect("admin/?module=users&action=edit_pass");
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
 ?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <?php 
            getMsg($message, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="password_old">Mật khẩu củ</label>
                     <input type="password" id="password_old" name="password_old" class="form-control"
                        placeholder="Nhập mật khẩu củ">
                     <?php echo form_error('password_old', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="password">Mật khẩu mới</label>
                     <input type="password" id="password" name="password" class="form-control"
                        placeholder="Nhập mật khẩu mới">
                     <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="confirm_password">Nhập lại mật khẩu mới</label>
                     <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                        placeholder="Nhập lại mật khẩu">
                     <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Cập nhật</button>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin');
 ?>
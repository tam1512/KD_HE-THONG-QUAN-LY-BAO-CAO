<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng đặt lại mật khẩu, xác thực mail để đặt lại mật khẩu
 */
$data = [
   'title' => 'Đặt lại mật khẩu mới'
];

layout('header-login','admin', $data);


if(isLogin()) {
   redirect('admin');
}


//validate form
$token = getBody()['token'];

if(!empty($token)) {
   $queryToken = firstRaw("SELECT id, fullname, email FROM users WHERE forget_token ='$token'");

   if(!empty($queryToken)) {
      if(isPost()) {
         $errors = [];
         $password = trim(getBody()['password']);
         $confirmPassword = trim(getBody()['confirm_password']);
   
         if(empty($password)) {
            $errors['password']['required'] = 'Mật khẩu không được để trống';
         } else if(strlen($password) < 8) {
            $errors['password']['min'] = 'Mật khẩu phải có trên 7 ký tự';
         }
   
         if(empty($confirmPassword)) {
            $errors['confirm_password']['required'] = 'Nhập lại mật khẩu không được để trống';
         } else if($password !== $confirmPassword) {
            $errors['confirm_password']['match'] = 'Mật khẩu không khớp';
         }
   
         if(!empty($errors)) {
            setFlashData('errors', $errors);
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
            setFlashData('msg_type', 'danger');
            redirect('admin?module=auth&action=reset&token='.$token);
         } else {
            $userId = $queryToken['id'];
            $fullname = $queryToken['fullname'];
            $email = $queryToken['email'];

            //update mật khẩu
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            //dữ liệu update
            $dataUpdate = [
               'password' => $hashPassword,
               'update_at' => date('Y-m-d H:i:s'),
               'forget_token' => null
            ];

            $updateStatus = update('users', $dataUpdate, "id = $userId");

            if($updateStatus) {
               //Gửi mail
               $subject = 'Thông báo đổi mật khẩu thành công';
               $content = "Chúc mừng $fullname đã đổi mật khẩu thành công. <br><br>";
               $content .= "Bạn có thể đăng nhập ngay với đường link sau: <br><br>";
               $content .= _WEB_HOST_ROOT."admin?module=auth&action=login<br><br>";
               $content .= 'Trân trọng';

               $sendMail = sendMail($email, $subject, $content);

               if($sendMail) {
                  setFlashData('msg', 'Thay đổi mật khẩu thành công');
                  setFlashData('msg_type', 'success');
                  redirect('admin?module=auth&action=login');
               } else {
                  setFlashData('msg', 'Lỗi hệ thống. Bạn không thể đổi mật khẩu');
                  setFlashData('msg_type', 'danger');
                  redirect('admin?module=auth&action=reset&token='.$token);
               }
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Bạn không thể đổi mật khẩu');
               setFlashData('msg_type', 'danger');
               redirect('admin?module=auth&action=reset&token='.$token);
            }
         }
      }

   } else {
      getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
      die();
   }
} else {
   getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
   die();
}


$errors = getFlashData('errors');
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');


 ?>

<div class="row">
   <div class="col-6" style="margin: 20px auto;">
      <h3 class="text-center text-uppercase">Đặt lại mật khẩu</h3>
      <?php getMsg($msg, $msgType) ?>
      <form action="" method="post">
         <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu mới...">
            <?php echo form_error('password', $errors, '<span class = "error">', '</span>') ?>
         </div>
         <div class="form-group">
            <label for="confirm_password">Nhập lại mật khẩu</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
               placeholder="Nhập lại mật khẩu mới...">
            <?php echo form_error('confirm_password', $errors, '<span class = "error">', '</span>') ?>
         </div>
         <button class="btn btn-primary btn-block" type="submit">Xác nhận</button>
         <hr>
         <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
         <input type="hidden" name="token" value="<?php echo $token; ?>">
      </form>
   </div>
</div>

<?php
  layout('footer-login', 'admin');
 ?>
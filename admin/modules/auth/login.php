<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng đăng nhập
 */
$data = [
   'title' => 'Đăng Nhập Hệ Thống'
];

layout('header-login','admin', $data);

autoLogin();
if(isLogin()) {
   redirect('admin');
}

//validate form
if(isPost()) {

   $errors = [];

   $email = trim(getBody()['email']);
   $password = trim(getBody()['password']);

   if(empty($email)) {
      $errors['email']['required'] = 'Email không được để trống';
   } else {
      $queryEmail = getRows("SELECT id FROM users WHERE email = '$email' AND status = 1");
      if($queryEmail == 0) {
         $errors['email']['match'] = 'Địa chỉ email không đúng hoặc chưa được kích hoạt';
      }
   }

   if(empty($password)) {
      $errors['password']['required'] = 'Mật khẩu không được để trống';
   } else {
      $checkEmail = empty($errors['email']) ? true : false;
      if($checkEmail) {
         $queryPassword = firstRaw("SELECT password FROM users WHERE email = '$email'");
         $passwordHash = $queryPassword['password'];
         if(!password_verify($password, $passwordHash)) {
            $errors['password']['match'] = 'Mật khẩu không đúng';
         }
      }
   }

   if(empty($errors)) {
      // Đăng nhập thành công
      //Lấy userID
      $user_id = firstRaw("SELECT id FROM users WHERE email = '$email'")['id'];

      //Tạo login token 
      $login_token = sha1(uniqid().time());
      // Thêm login token vào bảng login_token
      $dataInsert = [
         'user_id' => $user_id,
         'token' => $login_token,
         'create_at' => date('Y-m-d H:i:s'),
      ];
      $insertStatus = insert('login_token', $dataInsert);
      if($insertStatus) {
         setSession('login_token', $login_token);
         setFlashData('msg', 'Đăng nhập thành công');
         setFlashData('msg_type', 'success');
         saveActivity();
         redirect('admin');
      } else {
         setFlashData('msg', 'Lỗi hệ thống! Vui lòng thử lại sau');
         setFlashData('msg_type', 'danger');
         redirect('admin?dang-nhap');
      }

   } else {
      // Đăng nhập thất bại
      setFlashData('errors', $errors);
      setFlashData('old', getBody());
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      redirect('admin?dang-nhap');
   }
}

$errors = getFlashData('errors');
$old = getFlashData('old');
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12 col-sm-12 col-md-6 col-lg-6" style="margin: 20px auto;">
         <h3 class="text-center text-uppercase">Đăng nhập hệ thống</h3>
         <?php getMsg($msg, $msgType) ?>
         <form action="" method="post">
            <div class="form-group">
               <label for="email">Email</label>
               <input type="text" name="email" id="email" class="form-control" placeholder="Địa chỉ email..."
                  value="<?php echo old('email', $old) ?>">
               <?php echo form_error('email', $errors, '<span class = "error">', '</span>') ?>
            </div>
            <div class="form-group">
               <label for="password">Mật khẩu</label>
               <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu">
               <?php echo form_error('password', $errors, '<span class = "error">', '</span>') ?>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Đăng nhập</button>
         </form>
      </div>
   </div>
</div>
<?php
  layout('footer-login', 'admin');
 ?>
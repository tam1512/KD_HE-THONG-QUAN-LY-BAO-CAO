<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng hiển thị Chữ ký người dùng
 */
if(!isLogin()) {
   redirect("admin/dang-nhap");
 }
 
$data = [
   'title' => 'Chữ ký người dùng'
];

 layout('header', 'admin', $data);
 layout('sidebar', 'admin');
 layout('breadcrumb', 'admin', $data);

$userId = isLogin()["user_id"];
$signDetail = firstRaw("SELECT sign_text, description FROM sign WHERE user_id = $userId");
$isSign = !empty($signDetail) ? true : false;

if(isPost()) {
   $errors = [];
   $body = getBody('post');
   $signText = trim($body['sign-text']);
   $description = trim($body['description']);

   //độ dài của {"lines":[]} lấy được từ json của sign ajax
   if(empty($signText) || strlen($signText) == 20  ) {
      $errors['sign_text']['required'] = 'Hãy ký và cố định chữ ký trước khi lưu';
   }

   if(empty($errors)) {
      $data = [
         'sign_text' => $signText,
         'description' => $description,
         'user_id' => $userId,
      ];
      
      $status = false;

      if(!$isSign) {
         $data['create_at'] = date('Y-m-d H:i:s');
         $status = insert('sign', $data);
      } else {
         $data['update_at'] = date('Y-m-d H:i:s');
         $status = update('sign', $data, "user_id = $userId");
      }

      if($status) {
         setFlashData('msg', 'Lưu chữ ký thành công.');
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
      redirect('admin/nguoi-dung/chu-ky-ca-nhan');
   }
}

$message = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$infor = $signDetail;
if(!empty($old)) {
   $infor = $old;
} 
?>
<div class="container">
   <?php getMsg($message, $msgType) ?>
   <form action="" method="POST">
      <div class="row">
         <div class="col-12">
            <div class="form-group">
               <label for="signature">Chữ ký: (<i class="error">Nhớ bấm xác nhận trước khi Lưu</i>)</label>
               <!-- Signature -->
               <div id="signature"></div>
               <?php echo form_error('sign_text', $errors, '<span class="error">', '</span>') ?>
               <div class="d-flex mt-2">
                  <button id="disable" class="btn btn-warning mr-2">Xác nhận</button>
                  <button id="clear" class="btn btn-success">Làm mới</button>
               </div>
            </div>
         </div>
         <div class="col-12">
            <div class="form-group">
               <label for="description">Mô tả:</label>
               <input type="text" id="description" name="description" class="form-control" placeholder="Mô tả..."
                  value="<?php echo form_infor('description', $infor) ?>">
            </div>
         </div>
      </div>
      <input type="hidden" name="sign-text" id="sign-text" value="<?php echo form_infor('sign-text', $infor) ?>">
      <button type="submit" class="btn btn-primary btn-sm">Lưu chữ ký</a>
   </form>
</div>
<hr>
<?php
  layout('footer', 'admin');
 ?>
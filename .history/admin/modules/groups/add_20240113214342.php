<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Hiển thị danh sách người dùng, phân trang, tìm kiếm
 */
 if(!isLogin()) {
   redirect("admin/?module=auth&action=login");
 }

 $groupId = getGroupId();
 $permissionData = getPermissionData($groupId);
 $checkPermission = checkPermission($permissionData, 'groups', 'add');

 if(!$checkPermission) {
   setFlashData('msg', 'Bạn không có quyền Thêm nhóm người dùng');
   setFlashData('msg_type', 'danger');
   redirect("admin/");
 }

$data = [
   'title' => 'Thêm nhóm người dùng'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý đăng ký

 if(isPost()) {

   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $description = trim($body['description']);
   $root = !empty(trim($body['root'])) ? trim($body['root']) : 0;

   if(empty($name)) {
      $errors['name']['required'] = 'Tên nhóm không được để trống';
   }

   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'description' => $description,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('groups', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm nhóm tài khoản thành công.');
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
      redirect('admin/?module=groups&action=add');
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

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
                     <label for="description">Mô tả</label>
                     <input type="text" id="description" name="description" class="form-control" placeholder="Mô tả..."
                        value="<?php echo old('description', $old) ?>">
                     <?php echo form_error('description', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Thêm</button>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer', 'admin', $data);
 ?>
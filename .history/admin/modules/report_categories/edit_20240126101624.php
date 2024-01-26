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
  $checkPermission = checkPermission($permissionData, 'report_categories', 'edit');
}  


if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Sửa danh mục biên bản');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

$data = [
   'title' => 'Chỉnh sửa danh mục'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

if(isGet()) {
   $cateId = trim(getBody()['id']);
   $page = trim(getBody()['page']);
   
   if(!empty($cateId)) {
      $defaultCate = firstRaw("SELECT name, code_category FROM report_categories WHERE id = '$cateId'");
      setFlashData('defaultCate', $defaultCate);
   } else {
      redirect("admin/danh-muc-bien-ban");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $codeReport = trim($body['code_category']);
   $cateId = trim($body['id']);
   $page = trim($body['page']);
   if(empty($name)) {
      $errors['name']['required'] = 'Tên danh mục không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'code_category' => $codeReport,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('report_categories', $dataUpdate, "id=$cateId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa danh mục biên bản thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/danh-muc-bien-ban?page='.$page);
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/danh-muc-bien-ban/chinh-sua/id=$cateId?page=$page");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultCate = getFlashData('defaultCate');
if(!empty($defaultCate)) {
   $old = $defaultCate;
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
                     <label for="name">Tên danh mục</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="form-group">
                     <label for="code_category">Số hiệu</label>
                     <input type="text" id="code_category" name="code_category" class="form-control"
                        placeholder="Số hiệu..." value="<?php echo old('code_category', $old) ?>">
                     <?php echo form_error('code_category', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $cateId ?>">
                  <input type="hidden" name="page" value="<?php echo $page ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa</button>
            <a href="<?php echo getLinkAdmin('report_categories') ?>" class="btn btn-success" type="submit">Quay
               lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
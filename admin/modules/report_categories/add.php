<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng thêm danh mục
 */
$data = [
   'title' => 'Thêm danh mục báo cáo'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);

 // Xử lý 

 if(isPost()) {

   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $code = trim($body['code_category']);

   if(empty($name)) {
      $errors['name']['required'] = 'Tên danh mục không được để trống';
   }


   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'code_category' => $code,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('report_categories', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm danh mục biên bản thành công.');
            setFlashData('msg_type', 'success');
      } else {
        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger'); 
      }
      redirect('admin/?module=report_categories');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect('admin/?module=report_categories&action=add');
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
               <div class="col-12">
                  <div class="form-group">
                     <label for="name">Tên danh mục</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group">
                     <label for="code_category">Số hiệu</label>
                     <input type="text" id="code_category" name="code_category" class="form-control"
                        placeholder="Số hiệu..." value="<?php echo old('code_category', $old) ?>">
                     <?php echo form_error('code_category', $errors, '<span class="error">', '</span>') ?>
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
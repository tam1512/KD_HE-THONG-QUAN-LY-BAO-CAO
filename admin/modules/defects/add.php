<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/?module=auth&action=login");
}

$groupId = getGroupId();
$permissionData = getPermissionData($groupId);
$checkPermission = checkPermission($permissionData, 'defects', 'add');

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Thêm lỗi');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}

$data = [
   'title' => 'Thêm lỗi'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 

$listAllCates = getRaw("SELECT id, name FROM defect_categories");

//Danh sách mức độ lỗi
$levels = [
   'Nghiêm trọng',
   'Nặng',
   'Nhẹ',
   'Có điều kiện'
];

 if(isPost()) {
   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $cateId = trim(getBody()['cate_id']);
   $level = trim($body['level']);
   $skip = empty($body['skip']) ? 0 : trim($body['skip']);

   if($level == 'Có điều kiện') {
      $heavy = trim($body['heavy']);
      $light = trim($body['light']);
      $unit = trim($body['unit']);
      if(empty($unit)) {
         $errors['unit']['required'] = 'Đơn vị không được để trống';
      }
      if(empty($heavy)) {
         $errors['heavy']['required'] = 'Nặng không được để trống';
      }
      if(empty($light)) {
         $errors['light']['required'] = 'Nhẹ không được để trống';
      }

      // biến đổi thành dạng json để lưu vào database
      if(!empty($heavy) && !empty($light) && !empty($unit)) {
         $level ='{"unit": "'.$unit.'","conditions":[{"name": "Nhẹ","condition": "<=","value" : '.$light.'},{"name" : "Nặng","condition" : ">","value" : '.$heavy.'}]}';
      }
   }
   
   if(empty($name)) {
      $errors['name']['required'] = 'Tên lỗi không được để trống';
   }
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataInsert = [
         'name' => $name,
         'level' => $level,
         'cate_id' => $cateId,
         'skip' => $skip,
         'create_at' => date('Y-m-d H:i:s'),
      ];

      $insertStatus = insert('defects', $dataInsert);
      if($insertStatus) {
            setFlashData('msg', 'Thêm lỗi thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/?module=defects');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=defects&action=add");
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
                     <label for="name">Tên lỗi</label>
                     <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục..."
                        value="<?php echo old('name', $old) ?>">
                     <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                  </div>
                  <div class="row" id="level-defect-wrapper">
                     <div class="col-3">
                        <div class="form-group">
                           <label for="level">Mức độ lỗi</label>
                           <select name="level" id='level' class="form-control">
                              <?php 
                                 if(!empty($levels)):
                                    foreach($levels as $value):
                              ?>
                              <option value="<?php echo $value?>" <?php 
                                 echo (!empty($old['level']) && $old['level'] == $value) ? 'selected' : false 
                              ?>>
                                 <?php 
                                    echo $value;
                                 ?>
                              </option>
                              <?php 
                                    endforeach;
                                 endif;
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-3">
                        <div class="form-group">
                           <label for="unit">Đơn vị tính</label>
                           <input type="text" name="unit" id='unit' class="form-control" placeholder='Đơn vị tính...'
                              value="<?php echo old('unit', $old)?>"
                              <?php echo (!empty($old['level']) && $old['level'] == 'Có điều kiện') ? '' : 'disabled' ?>>
                           <?php echo form_error('unit', $errors, '<span class="error">', '</span>') ?>
                        </div>
                     </div>
                     <div class="col-3">
                        <div class="form-group">
                           <label for="heavy">Số lượng đạt lỗi nặng</label>
                           <input type="text" name="heavy" id='heavy' class="form-control"
                              placeholder='Số lượng đạt lỗi nặng...' value="<?php echo old('heavy', $old)?>"
                              <?php echo (!empty($old['level']) && $old['level'] == 'Có điều kiện') ? '' : 'disabled' ?>>
                           <?php echo form_error('heavy', $errors, '<span class="error">', '</span>') ?>
                        </div>
                     </div>
                     <div class="col-3">
                        <div class="form-group">
                           <label for="light">Số lượng đạt lỗi nhẹ</label>
                           <input type="text" name="light" id='light' class="form-control"
                              placeholder='Số lượng đạt lỗi nhẹ...' value="<?php echo old('light', $old)?>"
                              <?php echo (!empty($old['level']) && $old['level'] == 'Có điều kiện') ? '' : 'disabled' ?>>
                           <?php echo form_error('light', $errors, '<span class="error">', '</span>') ?>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="cate_id">Danh mục lỗi</label>
                     <select name="cate_id" class="form-control">
                        <?php 
                           if(!empty($listAllCates)):
                              foreach($listAllCates as $cate):
                        ?>
                        <option value="<?php echo $cate['id'] ?>"
                           <?php echo (!empty($old['cate_id']) && $old['cate_id']==$cate['id'])? 'selected' : false ?>>
                           <?php echo $cate['name'] ?></option>
                        <?php 
                              endforeach;
                           endif;
                        ?>
                     </select>
                  </div>
                  <div class="form-group row">
                     <div class="col-sm-12">
                        <div class="form-check d-flex align-item-center">
                           <input class="form-check-input" type="checkbox" id="skip" name="skip" value=1>
                           <label class="form-check-label ml-2" for="skip">
                              Bỏ qua khi tính toán
                           </label>
                        </div>
                     </div>
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
  layout('footer','admin');
 ?>
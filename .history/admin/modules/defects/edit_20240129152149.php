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
  $checkPermission = checkPermission($permissionData, 'defects', 'edit');
}  

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Sửa lỗi');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Chỉnh Sửa Lỗi'
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


if(isGet()) {
   $defectId = trim(getBody()['id']);
   $page = trim(getBody()['page']);

   if(!empty($defectId)) {
      $defaultDefect = firstRaw("SELECT name, level, cate_id, skip FROM defects WHERE id = '$defectId'");
      $levelDefect = $defaultDefect['level']; 
      if(strpos($levelDefect, '{') !== false) {
         $defaultDefect['level'] = 'Có điều kiện';
         //Xử lý lấy unit, heavy, light
         $levelDefectJson = json_decode($levelDefect);
         $unit = $levelDefectJson->unit;
         $conditions = $levelDefectJson->conditions;
         foreach($conditions as $condition) {
            $name = $condition->name;
            if($name == 'Nhẹ') {
               $light = $condition->value;
            }
            if($name == 'Nặng') {
               $heavy = $condition->value;
            }
         }

         $defaultDefect['unit'] = $unit;
         $defaultDefect['heavy'] = $heavy;
         $defaultDefect['light'] = $light;
      }
      setFlashData('defaultDefect', $defaultDefect);
   } else {
      redirect("admin/loi");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $name = trim($body['name']);
   $defectId = trim($body['id']);
   $cateId = trim(getBody()['cate_id']);
   $page = trim(getBody()['page']);
   $level = trim($body['level']);
   $skip = empty($body['skip']) ? 0 : $body['skip'];

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
      $dataUpdate = [
         'name' => $name,
         'level' => $level,
         'cate_id' => $cateId,
         'skip' => $skip,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('defects', $dataUpdate, "id=$defectId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa lỗi thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/loi?page='.$page);
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/loi/chinh-sua/id=$defectId?page=$page");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultDefect = getFlashData('defaultDefect');
if(!empty($defaultDefect) && empty($old)) {
   $old = $defaultDefect;
}
 ?>

<div class="container">
   <div class="row">
      <div class="col">
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
                  <div class="form-group">
                     <label for="cate_id">Danh mục lỗi</label>
                     <select name="cate_id" class="form-control selectpicker" data-live-search="true"
                        data-title="Danh mục lỗi" data-width="100%">
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
                           <input class="form-check-input" type="checkbox" id="skip" name="skip" value=1
                              <?php echo (old('skip', $old) == 1 ? "checked" : false) ?>>
                           <label class="form-check-label ml-2" for="skip">
                              Bỏ qua khi tính toán
                           </label>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="id" value="<?php echo $defectId ?>">
                  <input type="hidden" name="page" value="<?php echo $page ?>">
               </div>
            </div>
            <button class="btn btn-primary" type="submit">Sửa</button>
            <a href="<?php echo getLinkAdmin('defects', '').'?page='.$page ?>" class="btn btn-success"
               type="submit">Quay lại</a>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
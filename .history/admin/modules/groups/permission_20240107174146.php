<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức phân quyề
 */
 
$groupId = trim(getBody()['id']);
$defaultGroup = firstRaw("SELECT name, permission FROM groups WHERE id = '$groupId'");
if(isGet()) {
   if(!empty($groupId)) {
      setFlashData('defaultGroup', $defaultGroup);
   } else {
      redirect("admin/?module=groups");
   }
}

$data = [
   'title' => 'Phân quyền: '.$defaultGroup['name']
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý phân quyền
 $modules = getRaw("SELECT * FROM modules");

 if(isPost()) {
   //Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   echo '<pre>';
   print_r($body);
   echo '</pre>';

   $errors = []; // mãng lưu trữ các lỗi

   // Lọc giá trị ban đầu
   $groupId = trim($body['id']);
   
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'permission' => $permission,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('groups', $dataUpdate, "id=$groupId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa nhóm người dùng thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      // redirect('admin/?module=groups');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      // redirect("admin/?module=groups&action=edit&id=$groupId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultGroup = getFlashData('defaultGroup');
if(!empty($defaultGroup)) {
   $old = $defaultGroup;
}
 ?>

<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <?php 
            getMsg($msg, $msgType);
         ?>
         <form action="" method="post">
            <table class="table table-bordered">
               <tr>
                  <th>Module</th>
                  <th>Chức năng</th>
               </tr>
               <?php 
                  if(!empty($modules)): 
                     foreach($modules as $module):
               ?>
               <tr>
                  <td width="20%"><?php echo $module['title'] ?></td>
                  <td>
                     <?php 
                        $actions = json_decode($module['actions'], true);
                        if(!empty($actions)):
                           foreach($actions as $key => $value):
                     ?>
                     <input type="checkbox" name="<?php echo $module['name']."[$key]" ?>"
                        id="<?php echo $module['name']."[$key]" ?>" value="1"><?php echo $value ?>
                     <?php
                           endforeach;
                        endif;
                     ?>
                  </td>
               </tr>
               <?php 
                     endforeach;
                  endif;
               ?>
            </table>
            <input type="hidden" name="id" value="<?php echo $groupId ?>">
            <button class="btn btn-primary" type="submit">Phân quyền</button>
            <a href="<?php echo getLinkAdmin('groups') ?>" class="btn btn-success" type="submit">Quay lại</a>
            <hr>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
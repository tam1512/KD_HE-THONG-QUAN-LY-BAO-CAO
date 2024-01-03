<?php
require_once 'E:\program File\xampp\htdocs\PHP\PHP_co_ban\module05\radix\config.php';
require_once _WEB_PATH_ROOT.'/includes/functions.php';
require_once _WEB_PATH_ROOT.'/includes/connect.php';
require_once _WEB_PATH_ROOT.'/includes/database.php';

//Xử lý filter modal
$filterModal = "";
if($_POST['action'] == 'modal_search') {
   if(!empty($_POST['keyword_modal'])) {
      $keywordModal = $_POST['keyword_modal'];
      $filterModal = " WHERE fullname LIKE '%$keywordModal%' OR email LIKE '%$keywordModal%'";
   }
}

//danh sách người đăng
$listAllUsers = getRaw("SELECT id, fullname, email FROM users $filterModal ORDER BY create_at DESC");
?>

<?php 
   if(!empty($listAllUsers)):
      $count = 0;
      foreach($listAllUsers as $user):
         $count++;
?>
<tr>
   <td><?php echo $count ?></td>
   <td>
      <?php
      echo $user['fullname']
      ?>
   </td>
   <td><?php echo $user['email'] ?></td>
   <td class="text-center">
      <a class="btn btn-success"
         href="<?php echo !empty($keyword) ? getLinkAdmin('services', '', ['keyword'=>$keyword, 'user_id'=>$user["id"]]) : getLinkAdmin('services', '', ['user_id'=>$user["id"]]) ?>">Chọn</a>
   </td>
</tr>
<?php 
endforeach; else:
?>
<tr>
   <td colspan="4" class="text-center alert alert-danger">Không có người đăng</td>
</tr>
<?php endif; ?>
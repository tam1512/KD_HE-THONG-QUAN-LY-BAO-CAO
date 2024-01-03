<?php
require_once 'E:\program File\xampp\htdocs\PHP\PHP_co_ban\module05\radix\config.php';
require_once _WEB_PATH_ROOT.'/includes/functions.php';
require_once _WEB_PATH_ROOT.'/includes/connect.php';
require_once _WEB_PATH_ROOT.'/includes/database.php';

//Xử lý filter modal
$filterModal = "";
if($_POST['action'] == 'level_defect') {
   if(!empty($_POST['item'])) {
      $item = $_POST['item'];
      var_dump($item);
   }
}
?>

<div class="col-3">
   <div class="form-group">
      <label for="<?php echo $item['name'] ?>"><?php echo $item['nameVie'] ?></label>
      <input type="text" name="<?php echo $item['name'] ?>" id='<?php echo $item['name'] ?>' class="form-control"
         placeholder='<?php echo $item['nameVie'] ?>...' value="<?php echo old($item['name'], $old)?>">
      <?php echo form_error($item['name'], $errors, '<span class="error">', '</span>') ?>
   </div>
</div>
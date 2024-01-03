<?php if(!defined('_INCODE')) die('Access denied...'); ?>
<div class="" style="width: 60%; margin: 20px auto; padding: 30px 40px; text-align: center">
   <h3 class='text-uppercase'>Lỗi Cơ Sở Dữ Liệu</h3>
   <hr>
   <p style="color:red;">
      <?php echo $e->getMessage() ?>
   </p>
   <p>
      File:
      <span style="color:red;"> <?php echo $e->getFile() ?> </span>
   </p>
   <p>
      Line:
      <span style="color:red;"> <?php echo $e->getLine() ?> </span>
   </p>
</div>
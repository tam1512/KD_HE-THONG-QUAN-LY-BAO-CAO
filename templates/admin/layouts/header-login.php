<?php
if(!defined('_INCODE')) die('Access denied...');
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo (!empty($data['title'])) ? $data['title'] : 'Unicode';  ?></title>
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>css/adminlte.min.css">
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/fontawesome-free/css/all.min.css">
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets'; ?>/css/style.css?ver=<?php echo rand(); ?>">
</head>

<body>
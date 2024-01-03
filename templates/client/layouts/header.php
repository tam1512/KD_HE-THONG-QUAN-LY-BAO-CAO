<?php
if(!defined('_INCODE')) die('Access denied...');

 if(!isLogin()) {
   setFlashData('msg', '');
   setFlashData('msg_type', '');
   redirect('?module=auth&action=login');
 }
 autoLogin();
 $isLogin = autoRemoveLoginToken();
 if(!$isLogin) {
    saveActivity();   
 }
//  autoRemoveLoginToken();
 $token = getSession('login_token');
 
 $queryToken = firstRaw("SELECT userId FROM loginToken WHERE token = '$token'");
 if(!empty($queryToken)) {
    $id = $queryToken['userId'];
    $queryUser = firstRaw("SELECT fullname FROM users WHERE id = '$id'");
    $fullname = $queryUser['fullname'];
 } else {
   setFlashData('msg', '');
   setFlashData('msg_type', '');
   redirect('?module=auth&action=login');
 }
 $linkLogout = _WEB_HOST_ROOT.'?module=auth&action=logout';

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo (!empty($data['title'])) ? $data['title'] : 'Unicode';  ?></title>
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/style.css?ver=<?php echo rand(); ?>">
</head>

<body>
   <header>
      <div class="container">
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="?module=users">Unicode</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav header-nav">
                  <li class="nav-item active">
                     <a class="nav-link" href="?">Trang chủ <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item dropdown profile">
                     <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Chào <?php echo $fullname ?>
                     </a>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo getLinkAdmin('users', 'profile') ?>">Thông tin cá
                           nhân</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?module=users&action=edit_pass&id=<?php echo $id ?>">Đổi mật
                           khẩu</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo $linkLogout ?>">Đăng xuất</a>
                     </div>
                  </li>
               </ul>
            </div>
         </nav>
      </div>
   </header>
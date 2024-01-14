<?php 
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  setFlashData('msg', '');
  setFlashData('msg_type', '');
  redirect('admin?module=auth&action=login');
}
autoLogin();
$isLogin = autoRemoveLoginToken();
if(!$isLogin) {
   saveActivity();   
}

$token = getSession('login_token');
$queryToken = firstRaw("SELECT user_id FROM login_token WHERE token = '$token'");
if(!empty($queryToken)) {
   $id = $queryToken['user_id'];
   $queryUser = firstRaw("SELECT fullname FROM users WHERE id = '$id'");
   $fullname = $queryUser['fullname'];

   $signText = firstRaw("SELECT sign_text FROM sign WHERE user_id = $id");
   if(empty($signText)) {
      setFlashData('msg', 'Chưa có chữ ký vui lòng tạo chữ ký');
      setFlashData('msg_type', 'danger');
   }

} else {
  setFlashData('msg', '');
  setFlashData('msg_type', '');
  redirect('admin?module=auth&action=login');
}
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo $data['title'].' - Quản trị Website' ?></title>
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Font Awesome -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/fontawesome-free/css/all.min.css">
   <!-- Ionicons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- FileSaver -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
   <!-- Tempusdominus Bbootstrap 4 -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
   <!-- iCheck -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
   <!-- JQVMap -->
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jqvmap/jqvmap.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>css/adminlte.min.css">
   <!-- overlayScrollbars -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
   <!-- Daterange picker -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/daterangepicker/daterangepicker.css">
   <!-- summernote -->
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/summernote/summernote-bs4.css">
   <!-- Style -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets'; ?>/css/select.css?ver=<?php echo rand(); ?>">
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets'; ?>/css/style.css?ver=<?php echo rand(); ?>">
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets'; ?>/js/fonts/Roboto-Medium-normal.js?ver=<?php echo rand(); ?>">
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets'; ?>/js/fonts/Roboto-Bold-bold.js?ver=<?php echo rand(); ?>">


   <!-- Jquery sign -->
   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
   <link
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/sign/css/jquery.signature.css?ver=<?php echo rand() ?>"
      rel="stylesheet">
   <!--[if IE]>
   <script src="excanvas.js"></script>
   <![endif]-->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   <script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/sign/js/jquery.signature.js"></script>

   <!-- Google Font: Source Sans Pro -->
   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/'?>ckeditor/ckeditor.js"></script>
   <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/'?>ckfinder/ckfinder.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
         <!-- Left navbar links -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
         </ul>

         <!-- SEARCH FORM -->
         <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
               <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
               <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                     <i class="fas fa-search"></i>
                  </button>
               </div>
            </div>
         </form>

         <!-- Right navbar links -->
         <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#" id="notification_click">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-danger navbar-badge" id="count_notification"></span>
               </a>
               <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification">
               </div>
            </li>
            <!-- Information user -->
            <li class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-user">
                     Chào <?php echo ucfirst($fullname) ?>
                  </i>
               </a>
               <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('users', 'profile') ?>" class="dropdown-item">
                     <i class="fa fa-info-circle mr-2"></i> Thông tin cá nhân
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('users', 'sign') ?>" class="dropdown-item">
                     <i class="fa fa-pen-square mr-2"></i> Chữ ký cá nhân
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('users', 'edit_pass') ?>" class="dropdown-item">
                     <i class="fa fa-cog mr-2"></i> Đổi mật khẩu
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="<?php echo getLinkAdmin('auth', 'logout') ?>" class="dropdown-item">
                     <i class="fa fa-sign-out-alt mr-2"></i> Đăng xuất
                  </a>
               </div>
            </li>
         </ul>
      </nav>
      <!-- /.navbar -->

      <!-- toast -->
      <div aria-live="polite" aria-atomic="true"
         style="position: fixed; top:100%; left: 0; right: 0; bottom: 0; z-index:100000" class="bg-danger">
         <!-- Position it -->
         <div style="position: absolute; bottom: 50px; right: 4px;" id="toast-content">

            <!-- Then put toasts within -->
            <a href="#">
               <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                  <div class="toast-header">
                     <img src="..." class="rounded mr-2" alt="...">
                     <strong class="mr-auto">Bootstrap</strong>
                     <small class="text-muted">just now</small>
                     <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="toast-body text-muted">
                     See? Just like this.
                  </div>
               </div>
            </a>

            <!-- <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
               <div class="toast-header">
                  <img src="..." class="rounded mr-2" alt="...">
                  <strong class="mr-auto">Bootstrap</strong>
                  <small class="text-muted">2 seconds ago</small>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="toast-body">
                  Heads up, toasts will stack automatically
               </div>
            </div> -->
         </div>
      </div>
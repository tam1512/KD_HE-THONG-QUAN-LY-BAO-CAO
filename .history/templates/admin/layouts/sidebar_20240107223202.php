<?php 
$userId = isLogin()["user_id"];
$userDetail = firstRaw("SELECT fullname, avatar FROM users WHERE id = $userId");

$groupId = getGroupId();
$permissionData = getPermissionData($groupId);

$isListsGroups = checkPermission($permissionData, 'groups', 'lists');
$isAddGroups = checkPermission($permissionData, 'groups', 'add');

$isListsUsers = checkPermission($permissionData, 'users', 'lists');
$isAddUsers = checkPermission($permissionData, 'users', 'add');

$isListsProductCategories = checkPermission($permissionData, 'product_categories', 'lists');
$isAddProductCategories = checkPermission($permissionData, 'product_categories', 'add');

$isListsProducts = checkPermission($permissionData, 'products', 'lists');
$isAddProducts = checkPermission($permissionData, 'products', 'add');

$isListsFactories = checkPermission($permissionData, 'factories', 'lists');
$isAddFactories = checkPermission($permissionData, 'factories', 'add');

$isListsDefectCategories = checkPermission($permissionData, 'defect_categories', 'lists');
$isAddDefectCategories = checkPermission($permissionData, 'defect_categories', 'add');

$isListsDefects = checkPermission($permissionData, 'defects', 'lists');
$isAddDefects = checkPermission($permissionData, 'defects', 'add');

$isListsReportCategories = checkPermission($permissionData, 'report_categories', 'lists');
$isAddReportCategories = checkPermission($permissionData, 'report_categories', 'add');

$isListsReports = checkPermission($permissionData, 'reports', 'lists');
$isAddReports = checkPermission($permissionData, 'reports', 'add');
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="<?php echo _WEB_HOST_ROOT.'/admin' ?>" class="brand-link">
      <img src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>img/AdminLTELogo.png" alt="AdminLTE Logo"
         class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Kim Đức Admin</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
            <img
               src="<?php echo empty($userDetail['avatar']) ? _WEB_HOST_TEMPLATE_ADMIN.'/assets/img/no-avatar.png' : $userDetail['avatar'] ?>"
               class="img-circle elevation-2" alt="<?php echo $userDetail['fullname'] ?>">
         </div>
         <div class="info">
            <a href="<?php echo getLinkAdmin('users', 'profile') ?>"
               class="d-block"><?php echo $userDetail['fullname'] ?></a>
         </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN ?>"
                  class="nav-link <?php echo activeMenuSidebar('') ? 'active' : false ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                     Tổng quan
                  </p>
               </a>
            </li>
            <?php if($isListsGroups): ?>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('groups', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=groups" ?>"
                  class="nav-link <?php echo activeMenuSidebar('groups', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                     Nhóm người dùng
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=groups" ?>"
                        class="nav-link <?php echo activeMenuSidebar('groups', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddGroups): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=groups&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('groups', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsUsers):
            ?>
            <li class="nav-item has-treeview <?php echo activeMenuSidebar('users', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=users" ?>"
                  class="nav-link <?php echo activeMenuSidebar('users', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     Quản lý người dùng
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=users" ?>"
                        class="nav-link <?php echo activeMenuSidebar('users', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddUsers): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=users&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('users', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsProductCategories):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('product_categories', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=product_categories" ?>"
                  class="nav-link <?php echo activeMenuSidebar('product_categories', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fa fa-object-group"></i>
                  <p>
                     Danh mục sản phẩm
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=product_categories" ?>"
                        class="nav-link <?php echo activeMenuSidebar('product_categories', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddProductCategories): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=product_categories&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('product_categories', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsProducts):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('products', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=products" ?>"
                  class="nav-link <?php echo activeMenuSidebar('products', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fab fa-product-hunt"></i>
                  <p>
                     Quản lý sản phẩm
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=products" ?>"
                        class="nav-link <?php echo activeMenuSidebar('products', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddProducts): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=products&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('products', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsFactories):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('factories', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=factories" ?>"
                  class="nav-link <?php echo activeMenuSidebar('factories', '', true) ? 'active' : false ?>">
                  <i class="fas fa-industry nav-icon"></i>
                  <p>
                     Quản lý cơ sở
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=factories" ?>"
                        class="nav-link <?php echo activeMenuSidebar('factories', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddFactories): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=factories&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('factories', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsDefectCategories):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('defect_categories', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=defect_categories" ?>"
                  class="nav-link <?php echo activeMenuSidebar('defect_categories', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-exclamation-triangle"></i>
                  <p>
                     Danh mục lỗi
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=defect_categories" ?>"
                        class="nav-link <?php echo activeMenuSidebar('defect_categories', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddDefectCategories): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=defect_categories&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('defect_categories', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsDefects):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('defects', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=defects" ?>"
                  class="nav-link <?php echo activeMenuSidebar('defects', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-exclamation-circle"></i>
                  <p>
                     Quản lý lỗi
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=defects" ?>"
                        class="nav-link <?php echo activeMenuSidebar('defects', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddDefects): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=defects&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('defects', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsReportCategories):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('report_categories', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=report_categories" ?>"
                  class="nav-link <?php echo activeMenuSidebar('report_categories', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                     Danh mục biên bản
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=report_categories" ?>"
                        class="nav-link <?php echo activeMenuSidebar('report_categories', '', ['edit', 'delete']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <?php if($isAddReportCategories): ?>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=report_categories&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('report_categories', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
                  <?php endif; ?>
               </ul>
            </li>
            <?php 
               endif; 
               if($isListsReports):
            ?>
            <li
               class="nav-item has-treeview <?php echo activeMenuSidebar('reports', '', true) ? 'menu-open' : false ?>">
               <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=reports" ?>"
                  class="nav-link <?php echo activeMenuSidebar('reports', '', true) ? 'active' : false ?>">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                     Quản lý biên bản
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=reports" ?>"
                        class="nav-link <?php echo activeMenuSidebar('reports', '', ['edit', 'delete','seen']) ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo _WEB_HOST_ROOT_ADMIN."/?module=reports&action=add" ?>"
                        class="nav-link <?php echo activeMenuSidebar('reports', 'add') ? 'active' : false ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm mới</p>
                     </a>
                  </li>
               </ul>
            </li>
            <?php 
               endif;
            ?>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php 
   //auth
   $route['dang-nhap'] = 'index.php?module=auth&action=login';
   $route['dang-xuat'] = 'index.php?module=auth&action=logout';

   //dashboard
   $route['/'] = 'index.php?module=dashboard&action=lists';
   $route['tong-quan'] = 'index.php?module=dashboard&action=lists';

   //defect_categories
   $route['danh-muc-loi'] = 'index.php?module=defect_categories&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=defect_categories&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=defect_categories&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=defect_categories&action=delete&id=$1';

   //defects
   $route['danh-muc-loi'] = 'index.php?module=defects&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=defects&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=defects&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=defects&action=delete&id=$1';

   //factories
   $route['danh-muc-loi'] = 'index.php?module=factories&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=factories&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=factories&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=factories&action=delete&id=$1';

   //groups
   $route['danh-muc-loi'] = 'index.php?module=groups&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=groups&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=groups&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=groups&action=delete&id=$1';
?>
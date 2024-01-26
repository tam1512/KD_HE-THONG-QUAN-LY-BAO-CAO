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

   //users
   $route['danh-muc-loi'] = 'index.php?module=users&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=users&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=users&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=users&action=delete&id=$1';

   //product_categories
   $route['danh-muc-loi'] = 'index.php?module=product_categories&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=product_categories&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=product_categories&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=product_categories&action=delete&id=$1';

   //products
   $route['danh-muc-loi'] = 'index.php?module=products&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=products&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=products&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=products&action=delete&id=$1';

   //report_categories
   $route['danh-muc-loi'] = 'index.php?module=report_categories&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=report_categories&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=report_categories&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=report_categories&action=delete&id=$1';

   //reports
   $route['danh-muc-loi'] = 'index.php?module=reports&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=reports&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=reports&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=reports&action=delete&id=$1';

   //statistical_reports
   $route['danh-muc-loi'] = 'index.php?module=statistical_reports&action=lists';
   $route['danh-muc-loi/them'] = 'index.php?module=statistical_reports&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=statistical_reports&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=statistical_reports&action=delete&id=$1';
?>
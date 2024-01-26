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
   $route['loi'] = 'index.php?module=defects&action=lists';
   $route['loi/them'] = 'index.php?module=defects&action=add';
   $route['loi/chinh-sua/id=(.+)'] = 'index.php?module=defects&action=edit&id=$1';
   $route['loi/xoa/id=(.+)'] = 'index.php?module=defects&action=delete&id=$1';

   //factories
   $route['co-so'] = 'index.php?module=factories&action=lists';
   $route['co-so/them'] = 'index.php?module=factories&action=add';
   $route['co-so/chinh-sua/id=(.+)'] = 'index.php?module=factories&action=edit&id=$1';
   $route['co-so/xoa/id=(.+)'] = 'index.php?module=factories&action=delete&id=$1';

   //groups
   $route['nhom-nguoi-dung'] = 'index.php?module=groups&action=lists';
   $route['nhom-nguoi-dung/them'] = 'index.php?module=groups&action=add';
   $route['nhom-nguoi-dung/chinh-sua/id=(.+)'] = 'index.php?module=groups&action=edit&id=$1';
   $route['nhom-nguoi-dung/xoa/id=(.+)'] = 'index.php?module=groups&action=delete&id=$1';
   $route['nhom-nguoi-dung/phan-quyen/id=(.+)'] = 'index.php?module=groups&action=permission&id=$1';

   //users
   $route['nguoi-dung'] = 'index.php?module=users&action=lists';
   $route['nguoi-dung/them'] = 'index.php?module=users&action=add';
   $route['nguoi-dung/chinh-sua/id=(.+)'] = 'index.php?module=users&action=edit&id=$1';
   $route['nguoi-dung/xoa/id=(.+)'] = 'index.php?module=users&action=delete&id=$1';

   //product_categories
   $route['danh-muc-san-pham'] = 'index.php?module=product_categories&action=lists';
   $route['danh-muc-san-pham/them'] = 'index.php?module=product_categories&action=add';
   $route['danh-muc-san-pham/chinh-sua/id=(.+)'] = 'index.php?module=product_categories&action=edit&id=$1';
   $route['danh-muc-san-pham/xoa/id=(.+)'] = 'index.php?module=product_categories&action=delete&id=$1';

   //products
   $route['san-pham'] = 'index.php?module=products&action=lists';
   $route['san-pham/them'] = 'index.php?module=products&action=add';
   $route['san-pham/chinh-sua/id=(.+)'] = 'index.php?module=products&action=edit&id=$1';
   $route['san-pham/xoa/id=(.+)'] = 'index.php?module=products&action=delete&id=$1';

   //report_categories
   $route['danh-muc-bien-ban'] = 'index.php?module=report_categories&action=lists';
   $route['danh-muc-bien-ban/them'] = 'index.php?module=report_categories&action=add';
   $route['danh-muc-bien-ban/chinh-sua/id=(.+)'] = 'index.php?module=report_categories&action=edit&id=$1';
   $route['danh-muc-bien-ban/xoa/id=(.+)'] = 'index.php?module=report_categories&action=delete&id=$1';

   //reports
   $route['bien-ban'] = 'index.php?module=reports&action=lists';
   $route['bien-ban/them'] = 'index.php?module=reports&action=add';
   $route['bien-ban/chinh-sua/id=(.+)'] = 'index.php?module=reports&action=edit&id=$1';
   $route['bien-ban/xoa/id=(.+)'] = 'index.php?module=reports&action=delete&id=$1';
   $route['bien-ban/xuat-pdf/id=(.+)'] = 'index.php?module=reports&action=export&id=$1';

   //statistical_reports
   $route['thong-ke'] = 'index.php?module=statistical_reports&action=lists';
   $route['thong-ke/xuat-excel'] = 'index.php?module=statistical_reports&action=export_excel';
?>
<?php 
   //auth
   $route['dang-nhap'] = 'index.php?module=auth&action=login';
   $route['dang-xuat'] = 'index.php?module=auth&action=logout';

   //dashboard
   $route['/'] = 'index.php?module=dashboard';
   $route['tong-quan'] = 'index.php?module=dashboard';

   //defect_categories
   $route['danh-muc-loi'] = 'index.php?module=defect_categories';
   $route['danh-muc-loi/them'] = 'index.php?module=defect_categories&action=add';
   $route['danh-muc-loi/chinh-sua/id=(.+)'] = 'index.php?module=defect_categories&action=edit&id=$1';
   $route['danh-muc-loi/xoa/id=(.+)'] = 'index.php?module=defect_categories&action=delete&id=$1';

   //defects
   $route['loi'] = 'index.php?module=defects';
   $route['loi/them'] = 'index.php?module=defects&action=add';
   $route['loi/chinh-sua/id=(.+)'] = 'index.php?module=defects&action=edit&id=$1';
   $route['loi/xoa/id=(.+)'] = 'index.php?module=defects&action=delete&id=$1';

   //factories
   $route['co-so'] = 'index.php?module=factories';
   $route['co-so/them'] = 'index.php?module=factories&action=add';
   $route['co-so/chinh-sua/id=(.+)'] = 'index.php?module=factories&action=edit&id=$1';
   $route['co-so/xoa/id=(.+)'] = 'index.php?module=factories&action=delete&id=$1';

   //groups
   $route['nhom-nguoi-dung'] = 'index.php?module=groups';
   $route['nhom-nguoi-dung/them'] = 'index.php?module=groups&action=add';
   $route['nhom-nguoi-dung/chinh-sua/id=(.+)'] = 'index.php?module=groups&action=edit&id=$1';
   $route['nhom-nguoi-dung/xoa/id=(.+)'] = 'index.php?module=groups&action=delete&id=$1';
   $route['nhom-nguoi-dung/phan-quyen/id=(.+)'] = 'index.php?module=groups&action=permission&id=$1';

   //users
   $route['nguoi-dung'] = 'index.php?module=users';
   $route['nguoi-dung/them'] = 'index.php?module=users&action=add';
   $route['nguoi-dung/thong-tin-ca-nhan'] = 'index.php?module=users&action=profile';
   $route['nguoi-dung/chu-ky-ca-nhan'] = 'index.php?module=users&action=sign';
   $route['nguoi-dung/doi-mat-khau'] = 'index.php?module=users&action=edit_pass';
   $route['nguoi-dung/chinh-sua/id=(.+)'] = 'index.php?module=users&action=edit&id=$1';
   $route['nguoi-dung/xoa/id=(.+)'] = 'index.php?module=users&action=delete&id=$1';

   //product_categories
   $route['danh-muc-san-pham'] = 'index.php?module=product_categories';
   $route['danh-muc-san-pham/them'] = 'index.php?module=product_categories&action=add';
   $route['danh-muc-san-pham/chinh-sua/id=(.+)'] = 'index.php?module=product_categories&action=edit&id=$1';
   $route['danh-muc-san-pham/xoa/id=(.+)'] = 'index.php?module=product_categories&action=delete&id=$1';

   //products
   $route['san-pham'] = 'index.php?module=products';
   $route['san-pham/them'] = 'index.php?module=products&action=add';
   $route['san-pham/chinh-sua/id=(.+)'] = 'index.php?module=products&action=edit&id=$1';
   $route['san-pham/xoa/id=(.+)'] = 'index.php?module=products&action=delete&id=$1';

   //report_categories
   $route['danh-muc-bao-cao'] = 'index.php?module=report_categories';
   $route['danh-muc-bao-cao/them'] = 'index.php?module=report_categories&action=add';
   $route['danh-muc-bao-cao/chinh-sua/id=(.+)'] = 'index.php?module=report_categories&action=edit&id=$1';
   $route['danh-muc-bao-cao/xoa/id=(.+)'] = 'index.php?module=report_categories&action=delete&id=$1';

   //reports
   $route['bao-cao'] = 'index.php?module=reports';
   $route['bao-cao/thong-bao'] = 'index.php?module=reports&action=notifications';
   $route['bao-cao/them'] = 'index.php?module=reports&action=add';
   $route['bao-cao/chinh-sua/id=(.+)'] = 'index.php?module=reports&action=edit&id=$1';
   $route['bao-cao/xoa/id=(.+)'] = 'index.php?module=reports&action=delete&id=$1';
   $route['bao-cao/xuat-pdf/id=(.+)'] = 'index.php?module=reports&action=export&id=$1';
   $route['bao-cao/xem-anh-loi/id=(.+)'] = 'index.php?module=reports&action=seen_images_report_defect&id=$1';
   $route['bao-cao/xem-anh-loi-bao-cao/id=(.+)'] = 'index.php?module=reports&action=seen_images_defect&id=$1';
   $route['bao-cao/xoa-loi-bao-cao/id=(.+)'] = 'index.php?module=reports&action=report_defect_delete&id=$1';
   $route['bao-cao/xem/id=(.+)'] = 'index.php?module=reports&action=seen&id=$1';
   $route['bao-cao/user_id=(.+)'] = 'index.php?module=reports&user_id=$1';
   $route['bao-cao/factory_id=(.+)'] = 'index.php?module=reports&factory_id=$1';
   $route['bao-cao/conclusion=(.+)'] = 'index.php?module=reports&conclusion=$1';
   $route['bao-cao/chi-tiet/id=(.+)'] = 'index.php?module=reports&action=defect_detail&id=$1';
   $route['bao-cao/ky-nhanh/id=(.+)'] = 'index.php?module=reports&action=quick_sign&id=$1';
   $route['bao-cao/xac-nhan-bao-cao/id=(.+)'] = 'index.php?module=reports&action=confirm_report&id=$1';

   //statistical_reports
   $route['thong-ke'] = 'index.php?module=statistical_reports';
   $route['thong-ke/xuat-excel'] = 'index.php?module=statistical_reports&action=export_excel';
?>
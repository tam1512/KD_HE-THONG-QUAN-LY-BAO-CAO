<?php
/**
 * Chứa các tham số cấu hình
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

//Thiết lập hằng số cho client
const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'lists';

//Thiết lập hằng số cho admin
const _MODULE_DEFAULT_ADMIN = 'dashboard';


const _INCODE = true; // ngăn chặn hành vi truy cập trực tiếp vào file

// Thiết lập host
define('_WEB_HOST_ROOT', 'http://'.$_SERVER['HTTP_HOST'].'/KimDuc/radix'); //địa chỉ trang chủ
define('_WEB_HOST_ROOT_ADMIN', 'http://'.$_SERVER['HTTP_HOST'].'/KimDuc/radix/admin'); //địa chỉ trang chủ admin

// Đường dẫn thiết lập template của client
define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT.'/templates/client');

// Đường dẫn thiết lập template của admin
define('_WEB_HOST_TEMPLATE_ADMIN', _WEB_HOST_ROOT.'/templates/admin');


// Thiết lập path
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_ROOT_ADMIN', _WEB_PATH_ROOT.'\admin');
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT.'\templates');

// thiết lập kết nối csdl
const _HOST = 'localhost';
const _USER = 'root';
const _PASS = ''; //Ampp _PASS = 'mysql';
const _DB = 'kimduc';
const _DRIVER = 'mysql';

//Phân trang
const _USER_ON_PAGE = 2;
const _GROUP_ON_PAGE = 3;
const _SERVICE_ON_PAGE = 3;
const _PAGE_ON_PAGE = 3;

const _ITEM_ON_PAGE = 3;

//giới hạn hiển thị số trang
const _LIMIT_PAGINATION = 10;

//Thời gian hủy phiên đăng nhập
const _TIME_OUT_LOGIN = 60;
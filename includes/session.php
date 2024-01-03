<?php
if(!defined('_INCODE')) die('Access denied...');
// Các hàm xử lý session

// Hàm tạo hoặc gán session
function setSession($key, $value) {
   if(session_id()) { //có session_start()
      $_SESSION[$key] = $value;
      return true;
   }
   
   return false;
}

// Hàm lấy , đọc Session
function getSession($key = '') {
   if(empty($key)) {
      return $_SESSION;
   } else {
      if(isset($_SESSION[$key])) {
         return $_SESSION[$key];
      }
   }

   return false;
}

// Hàm xóa session
function removeSession($key = '') {
   if(empty($key)) {
      session_destroy();
      return true;
   } else {
      if(isset($_SESSION[$key])) {
         unset($_SESSION[$key]);
         return true;
      }
   }

   return false;
}

// Tạo Flash Session (một dạng session đặc biệt, khi bị lấy ra dữ liệu sẽ tự động bị xóa khỏi session, vd: thông báo khi đăng nhập thành công)
function setFlashData($key, $value) {
   $key = 'flash_'.$key;
   return setSession($key, $value);
}

// Lấy Flash session (xóa session ngay sau khi lấy ra) 
function getFlashData($key) {
   $key = 'flash_'.$key;
   $data = getSession($key);
   removeSession($key);
   return $data;
}
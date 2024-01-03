<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Hàm kết nối csdl
 */

try {
   if (class_exists('PDO')) {
      $dsn = _DRIVER . ':dbname=' . _DB . ';host=' . _HOST;

      $options = [
         PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Đẩy lỗi vào ngoại lệ truy vấn
      ];

      $conn = new PDO($dsn, _USER, _PASS, $options);
   }
} catch (Exception $e) {
   require_once 'modules/errors/database.php';
   exit();
}
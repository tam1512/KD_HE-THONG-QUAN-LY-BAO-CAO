<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Các hàm xử lý csdl
 */
function query($sql, $data=[], $statementStatus = false) {
   global $conn;
   $query = false;   
   // echo $sql;
   try{
      $statement = $conn->prepare($sql);
      if(empty($data)) {
         $query = $statement->execute();
      } else {
         $query = $statement->execute($data);
      }
   }catch(Exception $e){
      if(_DEBUG) {
         require_once _WEB_PATH_ROOT.'/modules/errors/database.php';
      } else {
         require_once _WEB_PATH_ROOT.'/modules/errors/500.php';
      }
      die();
   }

   if($statementStatus && $query) {
      return $statement;
   }

   return $query;
}

function insert($table, $dataInsert) {
   // Lấy ra mảng key
   $arrKeys = array_keys($dataInsert);
   
   // Lấy ra chuỗi các field
   $fieldStr = implode(', ', $arrKeys);
   
   // lấy ra chuỗi value theo dạng :key
   $valueStr = ':'.implode(', :', $arrKeys);
   
   $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr);";
   
   return query($sql, $dataInsert);
}

function update($table, $dataUpdate, $condition) {
   $updateStr = '';
   foreach($dataUpdate as $key => $value) {
      $updateStr .= $key.' = :'.$key . ', ';
   }
   $updateStr = rtrim($updateStr, ', ');

   if(empty($condition)) {
      $sql = "UPDATE $table SET $updateStr";
   } else {
      $sql = "UPDATE $table SET $updateStr WHERE $condition";
   }
   return query($sql, $dataUpdate);
}

function delete($table, $condition = '') {
   $sql = '';
   if(empty($condition)) {
      $sql = "DELETE FROM $table";
   } else {
      $sql = "DELETE FROM $table WHERE $condition";
   }

   return query($sql);
}

// Lấy dữ liệu từ câu lệnh SQL - lấy tất cả
function getRaw($sql) {
   $statement = query($sql, [], true);
   if(is_object($statement)) {
      $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $dataFetch;
   }

   return false;
}

// Lấy dữ liệu từ câu lệnh SQL - lấy row đầu tiên
function firstRaw($sql) {
   $statement = query($sql, [], true);
   if(is_object($statement)) {
      $dataFetch = $statement->fetch(PDO::FETCH_ASSOC);
      return $dataFetch;
   }

   return false;
}

//Lấy dữ liệu theo table, field, condition
function get($table, $field = '*', $condition = null) {
   $sql = "SELECT $field FROM $table";
   if(!empty($condition)) {
      $sql .= " WHERE $condition;";
   }
   return getRaw($sql);
}

function first($table, $field = '*', $condition = null) {
   $sql = "SELECT $field FROM $table";
   if(!empty($condition)) {
      $sql .= " WHERE $condition;";
   }
   return firstRaw($sql);
}

// Lấy ra số dòng truy vấn
function getRows($sql) {
   $statement = query($sql, [], true);
   if(!empty($statement)) {
      return $statement->rowCount();
   }
}

// Lấy ra id vừa insert
function insertId() {
   global $conn;
   return $conn->lastInsertId();
}
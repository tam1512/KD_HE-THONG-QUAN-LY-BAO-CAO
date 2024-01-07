<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
   redirect("admin?module=auth&action=login");
 }

 $body = getBody('get');
 $reportId = $body['report_id'];
 $page = $body['page'];

 $userId = isLogin()["user_id"];

 $reportSign = firstRaw("SELECT * FROM report_sign WHERE report_id = $reportId");
 $userXX = json_decode($reportSign['userXX'], true);
 $userQD = json_decode($reportSign['userQD'], true);
 $userPD = json_decode($reportSign['userPD'], true);
 $dataUpdate = [];
 if($userId == $userXX['user_id']) {
   $userXX['status'] = 1;
   $dataUpdate = [
      'userXX' => json_encode($userXX)
   ];
 }
 if($userId == $userQD['user_id']) {
   $userQD['status'] = 1;
   $dataUpdate = [
      'userQD' => json_encode($userQD)
   ];
 }
 if($userId == $userPD['user_id']) {
   $userPD['status'] = 1;
   $dataUpdate = [
      'userPD' => json_encode($userPD)
   ];
 }

 $statusUpdate = update('report_sign', $dataUpdate, "report_id = $reportId");

 if($statusUpdate) {
   setFlashData('msg', 'Ký biên bản thành công.');
   setFlashData('msg_type', 'success');
   redirect("admin/?module=reports&page=$page");
 } else {
   setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sau.');
   setFlashData('msg_type', 'danger');
   redirect("admin/?module=reports&page=$page");
 }
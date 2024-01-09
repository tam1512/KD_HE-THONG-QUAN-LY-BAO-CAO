<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
   redirect("admin?module=auth&action=login");
 }

 $body = getBody('get');
 $reportId = $body['report_id'];
 $page = !empty($body['page']) ? $body['page'] : false;
 
 $userId = isLogin()["user_id"];
 
$signText = firstRaw("SELECT sign_text FROM sign WHERE user_id = $userId");

 $errors = [];
 if(empty($signText)) {
  $errors['sign_text']['required'] = "Chưa có chữ ký, vui lòng tạo chữ ký";
 }

 if(isPost()) {
  $body = getBody('post');
  $sign = !empty($body['sign']) ? $body['sign'] : false;
  $fullname = !empty($body['fullname']) ? $body['fullname'] : false;

  if(!empty($sign) && !empty($fullname)) {
    $reportSign = firstRaw("SELECT userGC, sign_text_GC FROM report_sign WHERE report_id = $reportId");
    $userGC = json_decode($reportSign['userGC'], true);
    $userGC['fullname'] = $fullname;
    $userGC['sign_at'] = date('Y-m-d H:i:s');
    $dataUpdateSign = [
      "userGC" => json_encode($userGC),
      'sign_text_GC' => $sign
    ]; 
  
    $statusUpdate = update('report_sign', $dataUpdateSign, "report_id = $reportId");
    if($statusUpdate) {
      echo "Lưu chữ ký sơ sở gia công thành công";
    } else {
      echo "Lưu chữ ký sơ sở gia công thất bại";
    }
    return;
   }
 }

 if(empty($errors)) {
   $reportSign = firstRaw("SELECT * FROM report_sign WHERE report_id = $reportId");
   $notiReport = firstRaw("SELECT * FROM notifications WHERE report_id = $reportId"); 
   $userXX = json_decode($reportSign['userXX'], true);
   $userQD = json_decode($reportSign['userQD'], true);
   $userPD = json_decode($reportSign['userPD'], true);


   $userNotiXX = json_decode($notiReport['userXX'], true);
   $userNotiQD = json_decode($notiReport['userQD'], true);
   $userNotiPD = json_decode($notiReport['userPD'], true);
   $dataUpdateSign = [];
   $dataUpdateNoti = [];
   if($userId == $userXX['user_id']) {
     $userXX['status'] = 1;
     $userXX['sign_at'] = date('Y-m-d H:i:s');
     $dataUpdateSign = [
        'userXX' => json_encode($userXX)
     ];

     $userNotiXX['sign'] = 1;
     $dataUpdateNoti = [
        'userXX' => json_encode($userNotiXX)
     ];
   }
   if($userId == $userQD['user_id']) {
     $userQD['status'] = 1;
     $userQD['sign_at'] = date('Y-m-d H:i:s');
     $dataUpdateSign = [
        'userQD' => json_encode($userQD)
     ];

     $userQD['sign'] = 1;
     $dataUpdateNoti = [
        'userQD' => json_encode($userQD)
     ];
   }
   if($userId == $userPD['user_id']) {
     $userPD['status'] = 1;
     $userPD['sign_at'] = date('Y-m-d H:i:s');
     $dataUpdateSign = [
        'userPD' => json_encode($userPD)
     ];


     $userPD['sign'] = 1;
     $dataUpdateNoti = [
        'userPD' => json_encode($userPD)
     ];
   }
  
   $statusUpdate = update('report_sign', $dataUpdateSign, "report_id = $reportId");
  
   if($statusUpdate) {
     setFlashData('msg', 'Ký biên bản thành công.');
     setFlashData('msg_type', 'success');
     if(!empty($page)) {
       redirect("admin/?module=reports&page=$page");
      } else {
       redirect("admin/?module=reports&action=seen&id=$reportId");
     }
   } else {
     setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sau.');
     setFlashData('msg_type', 'danger');
     if(!empty($page)) {
      redirect("admin/?module=reports&page=$page");
     } else {
      redirect("admin/?module=reports&action=seen&id=$reportId");
     }
   }
 } else {
  setFlashData('msg', $errors['sign_text']['required']);
  setFlashData('msg_type', 'danger');
  redirect("admin/?module=users&action=sign");
 }
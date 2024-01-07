<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
   redirect("admin?module=auth&action=login");
 }

 $body = getBody('get');
 $reportId = $body['report_id'];
 $page = $body['page'];

 $userId = isLogin()["user_id"];
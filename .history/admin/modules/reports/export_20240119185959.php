<?php 
   use Dompdf\Dompdf;
   if(!defined('_INCODE')) die('Access denied...');

   if(!isLogin()) {
     redirect("admin/?module=auth&action=login");
   }
   
   $groupId = getGroupId();
   $group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
   $isRoot = !empty($group['root']) ? $group['root'] : false;

   if($isRoot) {
     $checkPermission = true;
   } else {
    $permissionData = getPermissionData($groupId);
    $checkPermission = checkPermission($permissionData, 'reports', 'export');
   }
   
   if(!$checkPermission) {
     setFlashData('msg', 'Bạn không có quyền Xuất biên bản');
     setFlashData('msg_type', 'danger');
     redirect("admin/");
   }

   $reportId = getBody('get')['id'];

   if(empty($reportId)) {
    setFlashData('msg', 'Báo cáo đã bị xóa');
    setFlashData('msg_type', 'danger');
    redirect("admin/modules=reports");
  }

   $action = getBody('get')['action'];

   $link = getLinkAdmin('reports', 'defect_detail', ['id' => $reportId, 'action_old'=>$action]);
   $htmlContent = file_get_contents($link);

   $pdf = new Dompdf();
   // echo $htmlContent;

   $pdf->loadHtml($htmlContent);

   //optional - setup the paper size and orientation
   $pdf->setPaper('A4', 'portrait');

   //render the html as PDF
   $pdf->render();

  //page-number
$pageCount = $pdf->getCanvas()->get_page_count();

// Thêm số trang vào nội dung PDF
for ($i = 1; $i <= $pageCount; $i++) {
  $pageNumberHtml = '<span class="page-number">' . $i . '/' . $pageCount . '</span>';
  $pdf->getCanvas()->page_text(72, 18, $pageNumberHtml, null, 10, array(0, 0, 0));
}

   //output the generated PDF to Browser
   $pdf->stream('BCCL.'.uniqid().'.pdf', Array('Attachment'=>0));
?>
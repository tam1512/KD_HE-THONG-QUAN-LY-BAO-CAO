<?php 
   if(isPost()) {
      $body = getBody('post');
      $cateId = $body['cate_id'];
      $defectId = $body['defect_id'];
      $note = $body['note'];
      $defectQuatity = $body['defect_quantity'];
      $reportId = !empty($body['report_id']) ? $body['report_id'] : 'null';

      $defect = firstRaw("SELECT level, name, skip FROM defects WHERE id = $defectId");
      $cate = firstRaw("SELECT name FROM defect_categories WHERE id = $cateId");

      $files = fileMulti('files');

      $fileArrs = [];

      if(!empty($files)) {
         foreach($files as $file) {
            $config = [
               'upload_dir' => "\modules\\reports\uploads",
               'max_size' => 5242880,
               'allowed' => 'html, htm, txt, jpg, jpeg, png, gif, pdf, mp3, wav, sql',
               'change_file_name' => uniqid()
            ];
            $data = uploadFile($config,'files', $file);
            $fileArrs[] = $data;
         }
      }

      $defectItem = [
         'name' => $defect['name'],
         'level' => $defect['level'],
         'defect_id' => $defectId,
         'cate_id' => $cateId,
         'cate_defect_name' => $cate['name'],
         'defect_quantity' => $defectQuatity,
         'note' => $note,
         'skip' => $defect['skip'],
         'create_at' => Date('Y-m-d H:i:s')
      ];
      if(!empty($fileArrs)) {
         $defectItem['files'] = $fileArrs;
      }

      if($reportId != 'null') {
         $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
      } else {
         $listAllReportDefects = getSession("listAllReportDefectsAdd");
      }
      $listAllReportDefects[] = $defectItem;
      if($reportId == 'null') {
         setSession("listAllReportDefectsAdd", $listAllReportDefects);
      } else {
         setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
      }
      // echo json_encode($listAllReportDefects);
      echo $reportId;
   }
?>
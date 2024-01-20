<?php 
   if(isPost()) {
      $body = getBody('post');
      $level = !empty($body['level']) ? $body['level'] : false;
      $defectId = $body['defect_id'];
      $note = $body['note'];
      $defectQuatity = $body['defect_quantity'];
      $reportId = !empty($body['report_id']) ? $body['report_id'] : 'null';

      $defect = firstRaw("SELECT level, name, skip, cate_id FROM defects WHERE id = $defectId");
      $cateId = $defect["cate_id"];
      $cate = firstRaw("SELECT name FROM defect_categories WHERE id = $cateId");

      $defectImagesStr = !empty($body['images_defect']) ? $body['images_defect'] : false;
      // $files = fileMulti('files');

      // $fileArrs = [];

      // if(!empty($files)) {
      //    foreach($files as $file) {
      //       $config = [
      //          'upload_dir' => "\modules\\reports\uploads",
      //          'max_size' => 5242880,
      //          'allowed' => 'html, htm, txt, jpg, jpeg, png, gif, pdf, mp3, wav, sql',
      //          'change_file_name' => uniqid()
      //       ];
      //       $data = uploadFile($config,'files', $file);
      //       $fileArrs[] = $data;
      //    }
      // }


      $defectItem = [
         'name' => $defect['name'],
         'level' => !empty($level) ? $level : $defect['level'],
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

      if($reportId == "null") {
         $listAllReportDefects = getSession("listAllReportDefectsAdd");
      } else {
         $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
      }
      $listAllReportDefects[] = $defectItem;

      if($reportId == 'null') {
         setSession("listAllReportDefectsAdd", $listAllReportDefects);
      } else {
         setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
      }
      echo json_encode($listAllReportDefects);
   }
?>
<?php 
      if(empty($errorsAdd)) {
         //xử lý upload file
         $files = fileMulti('files');
         
         // lấy danh sách file upload
         $dataFiles = [];
      
         if(!empty($files)) {
            foreach($files as $file) {
               $config = [
                  'upload_dir' => '/modules/reports/uploads',
                  'max_size' => 5242880,
                  'allowed' => 'html, htm, txt, jpg, jpeg, png, gif, pdf, mp3, wav, sql',
                  'change_file_name' => uniqid()
               ];
               $dataFiles[] = uploadFile($config,'files', $file);
            }
         }
      
         $dataInsert = [
            'id' => getMaxId($listAllReportDefectsAdd)+1,
            'name' => getNameDefectById($defectIdAdd, $listAllDefects),
            'level' => getLevelReportDefect($defectQuatity, $defectIdAdd),
            'defect_id' =>  $defectIdAdd,
            'cate_id' => $cateDefectIdAdd,
            'cate_defect_name' => getNameDefectCategoyById($cateDefectIdAdd, $listAllDefectCates),
            'defect_quantity' => $defectQuatity,
            'note' => $reportDefectNoteAdd,
            'create_at' => date('Y-m-d H:i:s'),
            'files' =>  $dataFiles 
         ];
      
         foreach($listAllReportDefectsAdd as $item) {
            if($dataInsert['defect_id'] == $item['defect_id']) {
               setFlashData('msg', 'Lỗi này đã tồn tại. Vui lòng chọn lỗi khác!');
               setFlashData('msg_type', 'danger');
               // redirect("admin/?module=reports&action=edit&id=$reportId");
            }
         }
      
         // đưa dữ liệu lên session
         $listAllReportDefectsAdd[] = $dataInsert;
         setSession('listAllReportDefectsAdd', $listAllReportDefectsAdd);
      
            
         } else {
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
            setFlashData('msg_type', 'danger');
            setFlashData('errorsAdd', $errorsAdd);
            setFlashData('oldAdd', $body);
            redirect("admin/?module=reports&action=edit&id=$reportId");
         }
?>
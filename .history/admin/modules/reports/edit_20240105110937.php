<?php
// Đang lỗi ở phần hiển thị danh sách các lỗi, danh mục lỗi khi đã chọn 
// fix: danh sách tên lỗi riêng, danh sach danh mục lỗi riêng (tên lỗi phụ thuộc và danh mục lỗi)
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa người dùng
 */
$data = [
   'title' => 'Chỉnh sửa biên bản'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

   
   deleteSessionOutReport();

   $statusReportArr = [
      1 => [
         "value" => "Đang xử lý",
         "color" => "secondary"
      ],
      2 => [
         "value" => "Chấp nhận",
         "color" => "success"
      ],
      3 => [
         "value" => "Trả sửa",
         "color" => "danger"
      ],
      4 => [
         "value" => "Nhận tiền trừ",
         "color" => "warning"
      ]
      ];
   
   $listUsersXX = getRaw("SELECT id, fullname, email FROM users WHERE group_id = 4");
   $listUsersQD = getRaw("SELECT id, fullname, email FROM users WHERE group_id = 5");
   $listUsersPD = getRaw("SELECT id, fullname, email FROM users WHERE group_id = 6");

 $listAllFactories = getRaw("SELECT id, name FROM factories");
 $listAllProducts = getRaw("SELECT id, name, cate_id FROM products");
 $listAllProductCates = getRaw("SELECT id, name FROM product_categories");
 $listAllDefectCates = getRaw("SELECT id, name FROM defect_categories");
 $listAllDefects = getRaw("SELECT id, name FROM defects");


if(isGet()) {
   $reportId = trim(getBody('get')['id']);
   if(!empty($reportId)) {
      $defaultReport = firstRaw("SELECT rp.factory_id, rp.product_id, rp.status, rs.userXX, rs.userQD, rs.userPD, f.name, p.name, po_code, conclusion, code_report, defect_finder, quantity_deliver, comment, suggest, rp.create_at FROM reports AS rp JOIN report_categories AS rp_c ON rp.cate_id = rp_c.id JOIN users AS u ON rp.user_id = u.id JOIN factories AS f ON rp.factory_id = f.id JOIN products AS p ON rp.product_id = p.id JOIN resultaql AS ra ON rp.id = ra.report_id JOIN report_sign As rs ON rs.report_id = rp.id WHERE rp.id = $reportId");;
      setFlashData('defaultReport', $defaultReport);
   } else {
      redirect("admin/?module=reports");
   }
}



if(!empty(getBody('post')['id'])) {
   $reportId = getBody('post')['id'];
}

$listAllReportDefects = getRaw("SELECT rd.id, df.name, df.level, df.skip, rd.defect_id, df.cate_id, (SELECT name FROM defect_categories WHERE df.cate_id = id) AS cate_defect_name, rd.defect_quantity, rd.note, rd.create_at FROM report_defect as rd JOIN defects as df ON df.id = rd.defect_id WHERE rd.report_id = $reportId ORDER BY cate_defect_name DESC");


foreach($listAllReportDefects as $key=>$value) {
   $rdId = $value['id'];
   $listAllImages = getRaw("SELECT * FROM report_defect_images WHERE report_defect_id = $rdId");
   foreach($listAllImages as $image) {
      $listAllReportDefects[$key]['files'][] = [
         'fileOr'=>$image['nameOr'],
         'file_name'=>$image['name'],
         'link'=>$image['image_link']
      ];
   }
}
if(!empty(getSession("listAllReportDefects[$reportId]"))) {
   $listAllReportDefects = getSession("listAllReportDefects[$reportId]");
} else {
   setSession("listAllReportDefects[$reportId]", $listAllReportDefects);
}

 if(isPost()) {

   // Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   //Lấy ra các đối tượng 
   $codeReport = trim($body['code_report']);
   $factoryId = trim($body['factory_id']);
   $productId = trim($body['product_id']);
   $defectFinder = trim($body['defect_finder']);
   $poCode = trim($body['po_code']);
   $quantityDeliver = trim($body['quantity_deliver']);
   $quantityInspect = trim($body['quantity_inspect']);
   $comment = trim($body['comment']);
   $suggest = trim($body['suggest']);

   $status = trim($body['status']);

   $userXXId = trim($body['userXX_id']);
   $userQDId = trim($body['userQD_id']);
   $userPDId = trim($body['userPD_id']);

   if(empty($codeReport)) {
      $errors['code_report']['required'] = 'Mã báo cáo không được bỏ trống';
   }
   if(empty($factoryId)) {
      $errors['factory_id']['required'] = 'Vui lòng chọn cơ sở';
   }
   if(empty($productId)) {
      $errors['product_id']['required'] = 'Vui lòng chọn sản phẩm';
   }
   if(empty($defectFinder)) {
      $errors['defect_finder']['required'] = 'Người phát hiện lỗi không được bỏ trống';
   }
   if(empty($poCode)) {
      $errors['po_code']['required'] = 'Số Po/Lot không được bỏ trống';
   }
   if(empty($quantityDeliver)) {
      $errors['quantity_deliver']['required'] = 'Số lượng giao không được bỏ trống';
   } else {
      if(!isNumberInt($quantityDeliver)) {
         $errors['quantity_deliver']['invalid'] = 'Số lượng giao phải là số';
      } else {
         if($quantityDeliver < 2) {
            $errors['quantity_deliver']['min'] = 'Số lượng giao phải lớn hơn 1';
         }
      }
   }

   
   if(empty($status)) {
      $errors['status']['required'] = 'Vui lòng chọn trạng thái';
   }

   if(empty($userXXId)) {
      $errors['userXX_id']['required'] = 'Vui lòng chọn người xem xét';
   }

   if(empty($userQDId)) {
      $errors['userQD_id']['required'] = 'Vui lòng chọn QĐ/PQĐ';
   }

   if(empty($userPDId)) {
      $errors['userPD_id']['required'] = 'Vui lòng chọn người phê duyệt';
   }

   if(empty($listAllReportDefects)) {
      $errors['listAllReportDefects']['required'] = 'Danh sách lỗi đang trống. Không thể thêm báo cáo!';
   }

   if(empty($errors)) {
      // Không có lỗi xảy ra
      //update report
      $dataUpdateReport = [
         'code_report' => $codeReport,
         'factory_id' => $factoryId,
         'product_id' => $productId,
         'po_code' => $poCode,
         'defect_finder' => $defectFinder,
         'quantity_deliver' => $quantityDeliver,
         'quantity_inspect' => $quantityInspect,
         'comment' => $comment,
         'suggest' => $suggest,
         'status'=> $status,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      //thay đổi người ký => status trả về 0, không thay đổi => giữ nguyên status

      $reportSign = firstRaw("SELECT * FROM report_sign WHERE report_id = $reportId");
      $userXX = $reportSign['userXX'];
      $userQD = $reportSign['userQD'];
      $userPD = $reportSign['userPD'];
       
      //chuyển json thành đối tượng
      $userXX = json_decode($userXX);
      $userQD = json_decode($userQD);
      $userPD = json_decode($userPD);
      
      $dataUpdateReportSign = [];
      if($userXX->user_id == $userXXId) {
         $dataUpdateReportSign["userXX"] = json_encode($userXX);
      } else {
         $dataUpdateReportSign["userXX"] = '{"user_id":'.$userXXId.', "status":2}';
      }
      if($userQD->user_id == $userQDId) {
         $dataUpdateReportSign["userQD"] = json_encode($userQD);
      } else {
         $dataUpdateReportSign["userQD"] = '{"user_id":'.$userQDId.', "status":2}';
      }
      if($userPD->user_id == $userPDId) {
         $dataUpdateReportSign["userPD"] = json_encode($userPD);
      } else {
         $dataUpdateReportSign["userPD"] = '{"user_id":'.$userPDId.', "status":2}';
      }

      //Mảng sau khi hoàn thành việc thêm và xóa
      $listAllReportDefectFinal = [];

      $listAllReportDefectHaveId = [];
      $listAllReportDefectToAdd = [];
      foreach($listAllReportDefects as $item) {
         if(isset($item['id'])) {
            $listAllReportDefectHaveId[] = $item;
         } else {
            $listAllReportDefectToAdd[] = $item;
            $listAllReportDefectFinal[] = $item;
         }
      }

      $listAllRD = getRaw("SELECT rd.id, df.name, df.level, df.skip, rd.defect_id, df.cate_id, (SELECT name FROM defect_categories WHERE df.cate_id = id) AS cate_defect_name, rd.defect_quantity, rd.note, rd.create_at FROM report_defect as rd JOIN defects as df ON df.id = rd.defect_id WHERE rd.report_id = $reportId ORDER BY cate_defect_name DESC");


      $listAllReportDefectToDelete = [];
      foreach($listAllRD as $item1) {
         $found = false;
         foreach($listAllReportDefectHaveId as $item2) {
            if($item1['id'] == $item2['id']) {
               $found = true;
               break;
            }
         }
         if(!$found) {
            $listAllReportDefectToDelete[] = $item1;
         } else {
            $listAllReportDefectFinal[] = $item1;
         }
      }

      //status của delete và add và updateAQL
      $addStatus = true;
      $deleteStatus = true;
      $updateAQL = true;

      //xóa report_defect
      if(!empty($listAllReportDefectToDelete)) {
         foreach($listAllReportDefectToDelete as $itemDelete) {
            $reportDefectId = $itemDelete['id'];
            $deleteImagesStatus = delete('report_defect_images', "report_defect_id = $reportDefectId");
            if($deleteImagesStatus) {
               $deleteReportDefectStatus = delete('report_defect', "id = $reportDefectId");
               if($deleteReportDefectStatus) {
   
               } else {
                  setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.(deleteReportDefectStatus)');
                  setFlashData('msg_type', 'danger');
                  $deleteStatus = false;
                  break;
               }
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau. (deleteImagesStatus)');
               setFlashData('msg_type', 'danger');
               $deleteStatus = false;
               break;
            }
         }
      }

      //Thêm report_defect
      if(!empty($listAllReportDefectToAdd)) {
         foreach($listAllReportDefectToAdd as $itemAdd) {
            $dataInsertReportDefect = [
               "report_id" => $reportId,
               "defect_id" => $itemAdd["defect_id"],
               "defect_quantity" => $itemAdd["defect_quantity"],
               'note' => $itemAdd["note"],
               'create_at' => date('Y-m-d H:i:s')
            ];

            $statusInsertReportDefect = insert('report_defect', $dataInsertReportDefect);
            if($statusInsertReportDefect) {
               if(!empty($itemAdd['files'])) {
                  $reportDefectId = firstRaw("SELECT id FROM report_defect WHERE report_id = $reportId AND defect_id = ".$itemAdd['defect_id'])['id'];
                  foreach($itemAdd['files'] as $file) {
                     $dataInsertImage = [
                        'image_link' => $file['link'],
                        'name' => $file['file_name'],
                        'nameOr' => $file['fileOr'],
                        'report_defect_id' => $reportDefectId,
                        'create_at' => date('Y-m-d H:i:s')
                     ];

                     $statusInsertImage = insert('report_defect_images', $dataInsertImage);
                     if($statusInsertImage) {

                     } else {
                        setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.(statusInsertImage)');
                        setFlashData('msg_type', 'danger');
                        $addStatus = false;
                        break;
                     }
                  }
               }
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.(statusInsertReportDefect)');
               setFlashData('msg_type', 'danger');
               $addStatus = false;
               break;
            }
         }
      }

      //updateAQL
      if($addStatus && $deleteStatus) {
         // lấy ra số lượng lỗi được cho phép
         $quantityDefectAccess = AQL($quantityDeliver);   
         $criticalDefects = $quantityDefectAccess['criticalDefects'];
         $majorDefects = $quantityDefectAccess['majorDefects'];
         $minorDefects = $quantityDefectAccess['minorDefects'];

         //Lấy ra số lỗi thực tế
         $quantityDefectReal = getSumDefectByType($listAllReportDefectFinal);
         $sumCriticalDefects = $quantityDefectReal['sumCriticalDefects'];
         $sumMajorDefects = $quantityDefectReal['sumMajorDefects'];
         $sumMinorDefects = $quantityDefectReal['sumMinorDefects'];

         //Lấy ra kết quả AQL
         $resultAQL = checkResultAQL($quantityDeliver, $sumCriticalDefects, $sumMajorDefects, $sumMinorDefects);

         //data updates to resultaql
         $dataUpdateResultAql= [
            "quantity_serious_accept" => $criticalDefects,
            "quantity_heavy_accept" => $majorDefects,
            "quantity_light_accept" => $minorDefects,
            "quantity_serious_real" => $sumCriticalDefects,
            "quantity_heavy_real" => $sumMajorDefects,
            "quantity_light_real" => $sumMinorDefects,
            "conclusion" => $resultAQL,
            'update_at' => date("Y-m-d H-i-s")
         ];

         $updateResultAqlStatus = update('resultaql', $dataUpdateResultAql, "report_id = $reportId");
         if($updateResultAqlStatus) {

         } else {
            setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.(statusInsertReportDefect)');
            setFlashData('msg_type', 'danger');
            $updateAQL = false;
         }
      }

      if($updateAQL) {
         //update thông tin report
         $updateStatus = update('reports', $dataUpdateReport, "id=$reportId");
         $updateStatusReportSign = update('report_sign', $dataUpdateReportSign, "report_id=$reportId");
         if($updateStatus && $updateStatusReportSign) {
               removeSession("listAllReportDefects[$reportId]");
               setFlashData('msg', 'Chỉnh sửa biên bản thành công.');
               setFlashData('msg_type', 'success');
         } else {
            setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
         }
         redirect('admin/?module=reports');
      }
   } else {
      if(!empty($errors['listAllReportDefects']['required'])) {
         setFlashData('msg', $errors['listAllReportDefects']['required']);
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      }
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/?module=reports&action=edit&id=$reportId");
   }

}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultReport = getFlashData('defaultReport');

if(empty($old)) {
   $old = $defaultReport;
}

//Xử lý AQL
// lấy ra số lượng lỗi được cho phép
$quantityDeliver = old('quantity_deliver', $old);
$quantityDefectAccess = AQL($quantityDeliver);   
$criticalDefects = $quantityDefectAccess['criticalDefects'];
$majorDefects = $quantityDefectAccess['majorDefects'];
$minorDefects = $quantityDefectAccess['minorDefects'];

//Lấy ra số lỗi thực tế
$quantityDefectReal = getSumDefectByType($listAllReportDefects);
$sumCriticalDefects = $quantityDefectReal['sumCriticalDefects'];
$sumMajorDefects = $quantityDefectReal['sumMajorDefects'];
$sumMinorDefects = $quantityDefectReal['sumMinorDefects'];

//Lấy ra kết quả AQL
$resultAQL = checkResultAQL($quantityDeliver, $sumCriticalDefects, $sumMajorDefects, $sumMinorDefects);

 ?>


<div class="container">
   <div class="row">
      <div class="col" style="margin: 20px auto;">
         <?php 
            getMsg($msg, $msgType);
         ?>

         <form action="" method="post">
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="code_report">Số</label>
                     <input type="text" id="code_report" name="code_report" class="form-control" placeholder="Số..."
                        value="<?php echo old('code_report', $old) ?>">
                     <?php echo form_error('code_report', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <label for="factory_id">Cơ sở</label>
                  <div class="form-group">
                     <select name="factory_id" id="factory_id" class="form-control mw-210">
                        <option value="0">Chọn cơ sở</option>
                        <?php 
                        if(!empty($listAllFactories)):
                           foreach($listAllFactories as $factory):
                     ?>
                        <option value="<?php echo $factory['id'] ?>"
                           <?php echo (!empty($old['factory_id']) && $factory['id'] == $old['factory_id']) ? 'selected' : false ?>>
                           <?php echo $factory['name']?>
                        </option>
                        <?php 
                           endforeach;
                        endif;
                     ?>
                     </select>
                     <?php echo form_error('factory_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <label for="product_id">Sản phẩm</label>
                  <div class="form-group">
                     <select name="product_id" id="product_id" class="form-control mw-210">
                        <option value="0">Chọn sản phẩm</option>
                        <?php
                        if(!empty($listAllProducts)):
                           foreach($listAllProducts as $product):
                     ?>
                        <option value="<?php echo $product['id'] ?>"
                           <?php echo (!empty($old['product_id']) && $product['id'] == $old['product_id']) ? 'selected' : false ?>>
                           <?php echo $product['name']?>
                        </option>
                        <?php 
                           endforeach;
                        endif;
                     ?>
                     </select>
                     <?php echo form_error('product_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="defect_finder">Người phát hiện lỗi</label>
                     <input type="text" id="defect_finder" name="defect_finder" class="form-control"
                        placeholder="Người phát hiện lỗi..." value="<?php echo old('defect_finder', $old) ?>">
                     <?php echo form_error('defect_finder', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="po_code">Số Po/Lot</label>
                     <input type="text" id="po_code" name="po_code" class="form-control" placeholder="Số Po/Lot..."
                        value="<?php echo old('po_code', $old) ?>">
                     <?php echo form_error('po_code', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="quantity_deliver">Số lượng giao</label>
                     <input type="text" id="quantity_deliver" name="quantity_deliver" class="form-control"
                        placeholder="Số lượng giao..." value="<?php echo old('quantity_deliver', $old) ?>">
                     <p id="render-quantity-check" class="mb-0"><b>Số lượng kiểm tra: </b><span></span></p>
                     <?php echo form_error('quantity_deliver', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="comment">Nhận xét/ Yêu cầu của QC</label>
                     <textarea id="comment" name="comment" class="form-control"
                        placeholder="Nhận xét/ Yêu cầu của QC..."><?php echo old('comment', $old) ?></textarea>
                     <?php echo form_error('comment', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="suggest">Hướng xử lý (Đối với trường hợp không đạt)</label>
                     <textarea id="suggest" name="suggest" class="form-control"
                        placeholder="Hướng xử lý..."><?php echo old('suggest', $old) ?></textarea>
                     <?php echo form_error('suggest', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <label for="status">Trạng thái</label>
                  <div class="form-group">
                     <select name="status" id="status" class="form-control mw-210">
                        <option value="0">Chọn trạng thái</option>
                        <?php 
                        if(!empty($statusReportArr)):
                           foreach($statusReportArr as $key=>$status):
                     ?>
                        <option value="<?php echo $key ?>"
                           <?php echo (!empty($old['status']) && $key == $old['status']) ? 'selected' : false ?>>
                           <?php echo $status['value']?>
                        </option>
                        <?php 
                           endforeach;
                        endif;
                     ?>
                     </select>
                     <?php echo form_error('status', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <label for="userXX_id">Người xem xét</label>
                  <div class="form-group">
                     <select name="userXX_id" id="userXX_id" class="form-control mw-210">
                        <option value="0">Chọn người xem xét</option>
                        <?php 
                           $userXX_id = null;
                           if(!empty($old['userXX'])) {
                              $userXX = json_decode($old['userXX'], true);
                              $userXX_id = $userXX['user_id'];
                           }
                        ?>
                        <?php 
                        if(!empty($listUsersXX)):
                           foreach($listUsersXX as $user):
                     ?>
                        <option value="<?php echo $user['id'] ?>"
                           <?php echo (!empty($userXX_id) && $user['id'] == $userXX_id) ? 'selected' : false ?>>
                           <?php echo $user['fullname']?>
                        </option>
                        <?php 
                           endforeach;
                        endif;
                     ?>
                     </select>
                     <?php echo form_error('userXX_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <label for="userQD_id">QĐ/PQĐ</label>
                  <div class="form-group">
                     <select name="userQD_id" id="userQD_id" class="form-control mw-210">
                        <option value="0">Chọn QĐ/PQĐ</option>
                        <?php 
                           $userQD_id = null;
                           if(!empty($old['userQD'])) {
                              $userQD = json_decode($old['userQD'], true);
                              $userQD_id = $userQD['user_id'];
                           }
                        ?>
                        <?php 
                        if(!empty($listUsersQD)):
                           foreach($listUsersQD as $user):
                     ?>
                        <option value="<?php echo $user['id'] ?>"
                           <?php echo (!empty($userQD_id) && $user['id'] == $userQD_id) ? 'selected' : false ?>>
                           <?php echo $user['fullname']?>
                        </option>
                        <?php 
                           endforeach;
                        endif;
                     ?>
                     </select>
                     <?php echo form_error('userQD_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-6">
                  <label for="userPD_id">Người phê duyệt</label>
                  <div class="form-group">
                     <select name="userPD_id" id="userPD_id" class="form-control mw-210">
                        <option value="0">Chọn người phê duyệt</option>
                        <?php 
                           $userPD_id = null;
                           if(!empty($old['userPD'])) {
                              $userPD = json_decode($old['userPD'], true);
                              $userPD_id = $userPD['user_id'];
                           }
                        ?>
                        <?php 
                        if(!empty($listUsersPD)):
                           foreach($listUsersPD as $user):
                     ?>
                        <option value="<?php echo $user['id'] ?>"
                           <?php echo (!empty($userPD_id) && $user['id'] == $userPD_id) ? 'selected' : false ?>>
                           <?php echo $user['fullname']?>
                        </option>
                        <?php 
                           endforeach;
                        endif;
                     ?>
                     </select>
                     <?php echo form_error('userPD_id', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-12 row">
                  <div class="col-4 d-flex">
                     <div class="form-group flex-1">
                        <label for="cate_defect">Chọn danh mục lỗi</label>
                        <div class="d-flex">
                           <select name="cate_defect" id="cate_defect" class="form-control mw-210">
                              <option value="0">Chọn danh mục lỗi</option>
                              <?php 
                                 if(!empty($listAllDefectCates)):
                                    foreach($listAllDefectCates as $defectCate):
                              ?>
                              <option value="<?php echo $defectCate['id'] ?>">
                                 <?php echo $defectCate['name']?>
                              </option>
                              <?php 
                                    endforeach;
                                 endif;
                              ?>
                           </select>
                        </div>
                        <span id="error-cate" class="error"></span>
                     </div>
                  </div>
                  <div class="col-4 d-flex">
                     <div class="form-group flex-1">
                        <label for="defect">Chọn lỗi</label>
                        <div class="d-flex">
                           <select name="defect" id="defect" class="form-control mw-210">
                              <option value="0">Chọn tên lỗi</option>
                              <?php 
                                 if(!empty($listAllDefects)):
                                    foreach($listAllDefects as $defect):
                              ?>
                              <option value="<?php echo $defect['id'] ?>">
                                 <?php echo $defect['name']?>
                              </option>
                              <?php 
                                    endforeach;
                                 endif;
                              ?>
                           </select>
                        </div>
                        <span id="error-defect" class="error"></span>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="form-group">
                        <label for="defect_quantity">Số lượng lỗi</label>
                        <input type="text" id="defect_quantity" class="form-control" placeholder="Nhận số lượng lỗi...">
                        <span class="error"></span>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="form-group">
                        <label for="file">Chọn ảnh</label>
                        <input type="file" id="file" class="form-control" multiple>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea id="note" class="form-control" placeholder="Nhập ghi chú..."></textarea>
                     </div>
                  </div>
                  <div class="col-2">
                     <br>
                     <br>
                     <button type="button" class="btn btn-primary btn-block" id="btnAddDefect">Thêm</button>
                  </div>
               </div>
               <div class="col-12">
                  <hr>
               </div>
               <table class="table table-bordered mb-0">
                  <tbody>
                     <tr>
                        <td rowspan="4" width="13%" style="text-align: left; vertical-align: middle;"><b>Kết quả AQL</b>
                        </td>
                        <td width="21%"><b>AQL 2.5-4.0 Level II</b></td>
                        <td width="19.5%"><b>Số lỗi tối đa cho phép</b></td>
                        <td class="text-center" width="27.54%"><b>Số lỗi thực tế</b></td>
                     </tr>
                     <tr>
                        <td><b>Nghiêm trọng</b></td>
                        <td class="text-center"><?php echo $criticalDefects ?></td>
                        <td class="text-center" id="sumCriticalDefects">
                           <?php echo $sumCriticalDefects ?></td>
                     </tr>
                     <tr>
                        <td><b>Nặng</b></td>
                        <td class="text-center" id="majorDefects"><?php echo $majorDefects ?></td>
                        <td class="text-center" id="sumMajorDefects"><?php echo $sumMajorDefects ?>
                        </td>
                     </tr>
                     <tr>
                        <td><b>Nhẹ</b></td>
                        <td class="text-center" id="minorDefects"><?php echo $minorDefects ?></td>
                        <td class="text-center" id="sumMinorDefects"><?php echo $sumMinorDefects ?>
                        </td>
                     </tr>
                     <tr>
                        <td><b>Kết luận:</b></td>
                        <td class="text-center" id="achieve"><i
                              class="far <?php echo ($resultAQL == 2) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>ĐẠT
                        </td>
                        <td class="text-center" id="not-achieve"><i
                              class="far <?php echo ($resultAQL == 1) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>KHÔNG
                           ĐẠT</td>
                        <td class="text-center"><i class="far fa-square mr-2"></i>CHỜ
                           XỬ LÝ</td>
                     </tr>
                  </tbody>
               </table>
               <div class="col-12">
                  <hr>
               </div>
               <h4 class="col-12 text-center">Bảng danh sách lỗi</h4>
               <div class="container">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th width="5%">STT</th>
                           <th>Tên</th>
                           <th>Mức độ</th>
                           <th>Danh mục</th>
                           <th>Số lượng</th>
                           <th>Ghi chú</th>
                           <th>Ngày tạo</th>
                           <th>Ảnh</th>
                           <th>Xóa</th>
                        </tr>
                     </thead>
                     <tbody id="content-table">
                        <?php 
                        if(!empty($listAllReportDefects)):
                           $count = 0;
                           foreach($listAllReportDefects as $key=>$report_defect):
                              $count++;
                     ?>
                        <tr>
                           <td><?php echo $count ?></td>
                           <td>
                              <?php
                              echo $report_defect['name']
                           ?>
                           </td>
                           <td><?php echo getLevelString($report_defect['level']) ?></td>
                           <td>
                              <?php echo $report_defect['cate_defect_name'] ?>
                           </td>
                           <td>
                              <?php echo $report_defect['defect_quantity'] ?>
                           </td>
                           <td>
                              <?php echo $report_defect['note'] ?>
                           </td>
                           <td>
                              <?php echo $report_defect['create_at'] ?>
                           </td>
                           <td>
                              <a class="btn btn-success" href="
                              <?php 
                                 echo getLinkAdmin('reports', 'seen_images_report_defect', ['report_id'=>$reportId, 'key'=>$key]) 
                              ?>">
                                 <i class="far fa-eye"></i>
                              </a>
                           </td>
                           <td>
                              <a class="btn btn-danger" href="
                              <?php 
                                 echo getLinkAdmin('reports', 'report_defect_delete', ['key'=>$key, 'report_id'=>$reportId]) 
                              ?>" onclick="confirm('Bạn có chắc chắn muốn xóa lỗi này ?')">
                                 <i class="fa fa-trash"></i>
                              </a>
                           </td>
                        </tr>
                        <?php 
                                    endforeach; else:
                                 ?>
                        <tr>
                           <td colspan="10" class="text-center alert alert-danger">Không có biên bản</td>
                        </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <input type="hidden" name="module" value="reports">
                  <input type="hidden" name="quantity_inspect" value="">
                  <input type="hidden" name="id" value="<?php echo $reportId ?>">

                  <button class="btn btn-primary" type="submit" name="submit_edit">Sửa</button>
                  <a href="<?php echo getLinkAdmin('reports')?>" class="btn btn-success" type="submit">Quay lại</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
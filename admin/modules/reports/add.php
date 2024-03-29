<?php
if(!defined('_INCODE')) die('Access denied...');

if(!isLogin()) {
  redirect("admin/dang-nhap");
}

$groupId = getGroupId();
$group = firstRaw("SELECT root FROM groups WHERE id = $groupId");
$isRoot = !empty($group['root']) ? $group['root'] : false;
if($isRoot) {
   $checkPermission = true;
} else {
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'reports', 'add');
}

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền Thêm báo cáo');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
$data = [
   'title' => 'Thêm Báo Cáo'
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
   ],
   5 => [
      "value" => "Chưa duyệt",
      "color" => "dark"
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
$idDefectOrder = null;
foreach($listAllDefects as $df) {
  if($df["name"] == "Khác") {
    $idDefectOrder = $df['id'];
  }
}
$listAllReportDefects = [];
if(!empty(getSession("listAllReportDefectsAdd"))) {
  $listAllReportDefects = getSession("listAllReportDefectsAdd");
} else {
  setSession("listAllReportDefectsAdd", $listAllReportDefects);
}

$infoDefault = [];
if(!empty(getSession('infoAdd'))) {
  $infoDefault = getSession('infoAdd');
}

$userId = isLogin()['user_id'];
$fullname = firstRaw("SELECT fullname FROM users WHERE id = $userId")['fullname'];

$signText = firstRaw("SELECT sign_text FROM sign WHERE user_id = $userId");

 if(isPost()) {

   // Validate form
   $body = getBody('post'); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   if(isset($body['report_add'])) {
       $status = 1;
   }

   if(isset($body['report_add_temp'])) {
       $status = 5;
   }

   //Lấy ra các đối tượng 
   $codeReport = trim($body['code_report']);
   $factoryId = trim($body['factory_id']);
   $productId = trim($body['product_id']);
   $poCode = trim($body['po_code']);
   $quantityDeliver = trim($body['quantity_deliver']);
   $quantityInspect = trim($body['quantity_inspect']);
   $comment = trim($body['comment']);
   $px = trim($body['PX']);

   $userXXId = trim($body['userXX_id']);
   $userQDId = trim($body['userQD_id']);
   $userPDId = trim($body['userPD_id']);

   if(empty($px)) {
      $errors['PX']['required'] = 'Phân xưởng không được bỏ trống';
   }
   if(empty($factoryId)) {
      $errors['factory_id']['required'] = 'Vui lòng chọn cơ sở';
   }
   if(empty($productId)) {
      $errors['product_id']['required'] = 'Vui lòng chọn sản phẩm';
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
      
      // data insert report
      $dataInsertReport = [
         'cate_id' => 1,
         'user_id' => $userId,
         'code_report' => $codeReport,
         'factory_id' => $factoryId,
         'product_id' => $productId,
         'po_code' => $poCode,
         'defect_finder' => $fullname,
         'quantity_deliver' => $quantityDeliver,
         'quantity_inspect' => $quantityInspect,
         'comment' => $comment,
         'status' => $status,
         'create_at' => date('Y-m-d H:i:s'),
      ];
   
      $statusInsertReport = insert('reports', $dataInsertReport);
      if($statusInsertReport) {
         $reportId = insertId();

         //Thêm ràng buộc chữ ký cho report
         $userXX = '{"user_id":'.$userXXId.', "status":2}';
         $userQD = '{"user_id":'.$userQDId.', "status":2}';
         $userPD = '{"user_id":'.$userPDId.', "status":2}';
         $dataInsertReportSign = [
            'report_id' => $reportId,
            "userXX" => $userXX,
            "userQD" => $userQD,
            "userPD" => $userPD,
         ];

         $statusinsertReportSign = insert('report_sign', $dataInsertReportSign);

         $addStatus = true;
         // Thêm report_defect
         if(!empty($listAllReportDefects)) {
            foreach($listAllReportDefects as $itemAdd) {
               $dataInsertReportDefect = [
                  "report_id" => $reportId,
                  "defect_id" => $itemAdd["defect_id"],
                  "level" => $itemAdd["level"],
                  "defect_quantity" => $itemAdd["defect_quantity"],
                  'note' => $itemAdd["note"],
                  'create_at' => $itemAdd['create_at']
               ];

               $statusInsertReportDefect = insert('report_defect', $dataInsertReportDefect);
               if($statusInsertReportDefect) {
                  if(!empty($itemAdd['files'])) {
                     $reportDefectId = firstRaw("SELECT id FROM report_defect WHERE report_id = $reportId AND defect_id = ".$itemAdd['defect_id'])['id'];
                     foreach($itemAdd['files'] as $file) {
                        $dataInsertImage = [
                           'image_link' => $file,
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

         // insertAQL
         if($addStatus && $statusinsertReportSign) {
            // lấy ra số lượng lỗi được cho phép
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

            // data updates to resultaql
            $dataInsertResultAql= [
               "report_id" => $reportId,
               "quantity_serious_accept" => $criticalDefects,
               "quantity_heavy_accept" => $majorDefects,
               "quantity_light_accept" => $minorDefects,
               "quantity_serious_real" => $sumCriticalDefects,
               "quantity_heavy_real" => $sumMajorDefects,
               "quantity_light_real" => $sumMinorDefects,
               "total_defect" => $sumCriticalDefects + $sumMajorDefects + $sumMinorDefects,
               "conclusion" => $resultAQL,
               'create_at' => date("Y-m-d H-i-s")
            ];

            $insertResultAqlStatus = insert('resultaql', $dataInsertResultAql);
            if($insertResultAqlStatus) {
               removeSession("listAllReportDefectsAdd");

               if(!empty($signText)) {
                  setFlashData('msg', 'Thêm báo cáo thành công.');
                  setFlashData('msg_type', 'success');
                  redirect('admin/bao-cao');
               } else {
                  setFlashData('msg', 'Chưa có chữ ký. Vui lòng tạo chữ ký');
                  setFlashData('msg_type', 'danger');
                  redirect('admin/nguoi-dung/chu-ky-ca-nhan');
               }

            } else {
               setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.(statusInsertReportDefect)');
               setFlashData('msg_type', 'danger');
               redirect('admin/bao-cao');
            }
         }
      }
   } else {

      if(!empty($errors['listAllReportDefects']['required'])) {
         setFlashData('msg', $errors['listAllReportDefects']['required']);
      } else {
         setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      }
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/bao-cao/them");
   }

}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
if(!empty($infoDefault)) {
  $old = $infoDefault;
} else {
    $old = getFlashData('old');
}

//Lấy ra số lỗi thực tế
$quantityDefectReal = getSumDefectByType($listAllReportDefects);
$sumCriticalDefects = $quantityDefectReal['sumCriticalDefects'];
$sumMajorDefects = $quantityDefectReal['sumMajorDefects'];
$sumMinorDefects = $quantityDefectReal['sumMinorDefects'];

 ?>


<div class="container-fluid">
   <div class="row">
      <div class="col">
         <?php 
            getMsg($msg, $msgType);
         ?>
         <form action="" method="post">
            <div class="row" id="infoAdd">
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                     <label for="PX">Phân xưởng<span style="color:red">*</span></label>
                     <input type="text" id="PX" name="PX" class="form-control" placeholder="Phân xưởng..."
                        value="<?php echo old('PX', $old) ?>">
                     <p id="render-code-report" class="mb-0"><b>Mã báo cáo: </b><span></span></p>
                     <?php echo form_error('PX', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="factory_id">Cơ sở<span style="color:red">*</span></label>
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
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="product_id">Sản phẩm<span style="color:red">*</span></label>
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
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                     <label for="defect_finder">Người phát hiện lỗi<span style="color:red">*</span></label>
                     <input type="text" id="defect_finder" name="defect_finder" class="form-control"
                        value="<?php echo ucfirst($fullname) ?>" disabled>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                     <label for="po_code">Số Po/Lot<span style="color:red">*</span></label>
                     <input type="text" id="po_code" name="po_code" class="form-control" placeholder="Số Po/Lot..."
                        value="<?php echo old('po_code', $old) ?>">
                     <?php echo form_error('po_code', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                     <label for="quantity_deliver">Số lượng giao<span style="color:red">*</span></label>
                     <input type="text" id="quantity_deliver" name="quantity_deliver" class="form-control"
                        placeholder="Số lượng giao..." value="<?php echo old('quantity_deliver', $old) ?>">
                     <p id="render-quantity-check" class="mb-0"><b>Số lượng kiểm tra: </b><span></span></p>
                     <?php echo form_error('quantity_deliver', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="status">Trạng thái<span style="color:red">*</span></label>
                  <div class="form-group">
                     <select name="status" id="status" class="form-control mw-210" disabled>
                        <option value="1">Chưa duyệt</option>
                     </select>
                     <?php echo form_error('status', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="userXX_id">Người xem xét<span style="color:red">*</span></label>
                  <div class="form-group">
                     <select name="userXX_id" id="userXX_id" class="form-control mw-210">
                        <option value="0">Chọn người xem xét</option>
                        <?php 
                        if(!empty($listUsersXX)):
                           foreach($listUsersXX as $user):
                     ?>
                        <option value="<?php echo $user['id'] ?>"
                           <?php echo (!empty($old['userXX_id']) && $user['id'] == $old['userXX_id']) ? 'selected' : false ?>>
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
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="userQD_id">QĐ/PQĐ<span style="color:red">*</span></label>
                  <div class="form-group">
                     <select name="userQD_id" id="userQD_id" class="form-control mw-210">
                        <option value="0">Chọn QĐ/PQĐ</option>
                        <?php 
                        if(!empty($listUsersQD)):
                           foreach($listUsersQD as $user):
                     ?>
                        <option value="<?php echo $user['id'] ?>"
                           <?php echo (!empty($old['userQD_id']) && $user['id'] == $old['userQD_id']) ? 'selected' : false ?>>
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
               <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="userPD_id">Người phê duyệt<span style="color:red">*</span></label>
                  <div class="form-group">
                     <select name="userPD_id" id="userPD_id" class="form-control mw-210">
                        <option value="0">Chọn người phê duyệt</option>
                        <?php 
                        if(!empty($listUsersPD)):
                           foreach($listUsersPD as $user):
                     ?>
                        <option value="<?php echo $user['id'] ?>"
                           <?php echo (!empty($old['userPD_id']) && $user['id'] == $old['userPD_id']) ? 'selected' : false ?>>
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
               <div class="col-12">
                  <div class="form-group">
                     <label for="comment">Nhận xét/ Yêu cầu của QC</label>
                     <textarea id="comment" name="comment" class="form-control"
                        placeholder="Nhận xét/ Yêu cầu của QC..."><?php echo old('comment', $old) ?></textarea>
                     <?php echo form_error('comment', $errors, '<span class="error">', '</span>') ?>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <hr>
            </div>
            <table class="table table-bordered mb-0 table-responsive">
               <tbody>
                  <tr>
                     <td rowspan="4" width="30%" style="text-align: left; vertical-align: middle;"><b>Kết quả AQL</b>
                     </td>
                     <td width="40%"><b>AQL 2.5-4.0 Level II</b></td>
                     <td width="25%"><b>Số lỗi tối đa cho phép</b></td>
                     <td class="text-center" width="25%"><b>Số lỗi thực tế</b></td>
                  </tr>
                  <tr>
                     <td><b>Nghiêm trọng</b></td>
                     <td class="text-center"><?php echo empty($criticalDefects) ? 0 : $criticalDefects ?></td>
                     <td class="text-center" id="sumCriticalDefects">
                        <?php echo empty($sumCriticalDefects) ? 0 : $sumCriticalDefects ?></td>
                  </tr>
                  <tr>
                     <td><b>Nặng</b></td>
                     <td class="text-center" id="majorDefects"><?php echo empty($majorDefects) ? 0 : $majorDefects ?>
                     </td>
                     <td class="text-center" id="sumMajorDefects">
                        <?php echo empty($sumMajorDefects) ? 0 : $sumMajorDefects ?>
                     </td>
                  </tr>
                  <tr>
                     <td><b>Nhẹ</b></td>
                     <td class="text-center" id="minorDefects"><?php echo empty($minorDefects) ? 0 : $minorDefects ?>
                     </td>
                     <td class="text-center" id="sumMinorDefects">
                        <?php echo empty($sumMinorDefects) ? 0 : $sumMinorDefects ?>
                     </td>
                  </tr>
                  <tr>
                     <td><b>Kết luận:</b></td>
                     <td class="text-center" id="achieve"><i
                           class="far <?php echo (!empty($resultAQL) && $resultAQL == 2) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>ĐẠT
                     </td>
                     <td class="text-center" id="not-achieve"><i
                           class="far <?php echo (!empty($resultAQL) && $resultAQL == 1) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>KHÔNG
                        ĐẠT</td>
                     <td class="text-center"><i class="far fa-square mr-2"></i>CHỜ
                        XỬ LÝ</td>
                  </tr>
               </tbody>
            </table>
            <div class="col-12">
               <hr>
            </div>
            <div class="row">
               <div class="col-12 row">
                  <div class="col-12 col-sm-12 col-md-4 col-lg-4 d-flex">
                     <div class="form-group flex-1">
                        <label for="defect">Chọn lỗi<span style="color:red">*</span></label>
                        <div class="d-flex">
                           <select name="defect" id="defect" class="form-control selectpicker" data-live-search="true"
                              data-title="Lỗi" data-width="100%">

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
                  <div class="col-12 col-sm-12 col-md-4 col-lg-4 d-flex">
                     <div class="form-group flex-1">
                        <label for="level">Mức độ lỗi<span style="color:red">*</span></label>
                        <div class="d-flex">
                           <select name="level" id="level" class="form-control mw-210">
                              <option value="Nghiêm trọng">Nghiêm trọng</option>
                              <option value="Nặng">Nặng</option>
                              <option value="Nhẹ">Nhẹ</option>
                           </select>
                        </div>
                        <span id="error-cate" class="error"></span>
                     </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="defect_quantity">Số lượng lỗi<span style="color:red">*</span></label>
                        <input type="text" id="defect_quantity" class="form-control" placeholder="Nhận số lượng lỗi...">
                        <span class="error"></span>
                     </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="images_defect">Ảnh lỗi</label>
                        <div class="row ckfinder-group">
                           <div class="col-9">
                              <textarea type="text" id="images_defect" class="form-control image-link disabled"
                                 placeholder="Đường dẫn ảnh..."><?php echo old('images_defect', $old) ?></textarea>
                           </div>
                           <div class="col-3">
                              <button type="button" class="btn btn-success btn-block ckfinder-choose-multi-image"><i
                                    class="fa fa-images"></i></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                     <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea id="note" class="form-control" placeholder="Nhập ghi chú..."></textarea>
                     </div>
                  </div>
                  <div class="col-4 col-sm-4 col-md-2 col-lg-2">
                     <button type="button" class="btn btn-primary btn-block mt-lg-5 mt-md-5"
                        id="btnAddDefect">Thêm</button>
                  </div>
               </div>
               <div class="col-12">
                  <hr>
               </div>
               <h4 class="col-12 text-center">Bảng danh sách lỗi</h4>
               <div class="container-fluid">
                  <table class="table table-bordered mb-0 table-responsive">
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
                              <input type="number" name="<?php echo $key ?>" class="form-control mw-80"
                                 value="<?php echo $report_defect['defect_quantity'] ?>">
                           </td>
                           <td class="defect-note">
                              <?php echo $report_defect['note'] ?>
                           </td>
                           <td>
                              <?php echo $report_defect['create_at'] ?>
                           </td>
                           <td>
                              <a class="btn btn-success" href="
                              <?php 
                                 echo !empty($reportId) ? getLinkAdmin('reports', 'seen_images_report_defect', ['id'=>$reportId]).'?key='.$key : getLinkAdmin('reports', 'seen_images_report_defect', ['id'=>"null"]).'?key='.$key; 
                              ?>">
                                 <i class="far fa-eye"></i>
                              </a>
                           </td>
                           <td>
                              <button class="btn btn-danger btnDeleteDefect" data-id="null"
                                 data-key="<?php echo $key ?>">
                                 <i class="fa fa-trash"></i>
                              </button>
                           </td>
                        </tr>
                        <?php 
                           endforeach; else:
                        ?>
                        <tr>
                           <td colspan="10" class="text-center alert alert-danger">Không có lỗi</td>
                        </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <input type="hidden" name="quantity_inspect" value="">
                  <input type="hidden" name="code_report" value="">
                  <input type="hidden" name="idDefectOrder" id="idDefectOrder" value="<?php echo $idDefectOrder ?>">

                  <button class="btn btn-success" type="submit" name="report_add">Lưu</button>
                  <button class="btn btn-danger" type="submit" name="report_add_temp">Lưu nháp</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
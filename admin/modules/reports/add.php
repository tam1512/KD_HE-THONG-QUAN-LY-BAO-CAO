<?php
// Đang lỗi ở phần hiển thị danh sách các lỗi, danh mục lỗi khi đã chọn 
// fix: danh sách tên lỗi riêng, danh sach danh mục lỗi riêng (tên lỗi phụ thuộc và danh mục lỗi)
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh sửa người dùng
 */
$data = [
   'title' => 'Thêm biên bản'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

   
   deleteSessionOutReport();

 $listAllFactories = getRaw("SELECT id, name FROM factories");
 $listAllProducts = getRaw("SELECT id, name, cate_id FROM products");
 $listAllProductCates = getRaw("SELECT id, name FROM product_categories");
 $listAllDefectCates = getRaw("SELECT id, name FROM defect_categories");
 $listAllDefects = getRaw("SELECT id, name FROM defects");
 $listAllReportDefects = [];
 if(!empty(getSession("listAllReportDefectsAdd"))) {
   $listAllReportDefects = getSession("listAllReportDefectsAdd");
} else {
   setSession("listAllReportDefectsAdd", $listAllReportDefects);
}


$userId = isLogin()['user_id'];

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
         'defect_finder' => $defectFinder,
         'quantity_deliver' => $quantityDeliver,
         'quantity_inspect' => $quantityInspect,
         'comment' => $comment,
         'suggest' => $suggest,
         'create_at' => date('Y-m-d H:i:s'),
      ];
      
      $statusInsertReport = insert('reports', $dataInsertReport);
      if($statusInsertReport) {
         $reportId = insertId();
         $addStatus = true;
         // Thêm report_defect
         if(!empty($listAllReportDefects)) {
            foreach($listAllReportDefects as $itemAdd) {
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

         // insertAQL
         if($addStatus) {
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
               "conclusion" => $resultAQL,
               'create_at' => date("Y-m-d H-i-s")
            ];

            $insertResultAqlStatus = insert('resultaql', $dataInsertResultAql);
            if($insertResultAqlStatus) {
               removeSession("listAllReportDefectsAdd");
               setFlashData('msg', 'Thêm biên bản thành công.');
               setFlashData('msg_type', 'success');
            } else {
               setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.(statusInsertReportDefect)');
               setFlashData('msg_type', 'danger');
            }
            redirect('admin/?module=reports');
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
      redirect("admin/?module=reports&action=add");
   }

}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

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
                     <td class="text-center"><?php echo empty($criticalDefects) ? 0 : $criticalDefects ?></td>
                     <td class="text-center" id="sumCriticalDefects">
                        <?php echo empty($sumCriticalDefects) ? 0 : $sumCriticalDefects ?></td>
                  </tr>
                  <tr>
                     <td><b>Nặng</b></td>
                     <td class="text-center" id="majorDefects"><?php echo empty($majorDefects) ? 0 : $majorDefects ?>
                     </td>
                     <td class="text-center" id="sumMajorDefects">
                        <?php echo empty($sumMajorDefects) ? 0 : $criticalDefects ?>
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
                           <td colspan="10" class="text-center alert alert-danger">Không có lỗi</td>
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

                  <button class="btn btn-success" type="submit" name="submit_edit">Thêm</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
  layout('footer','admin');
 ?>
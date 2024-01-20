<?php
layout('header-none', 'admin');
if(!empty(getBody('get')['id'])) {
   $reportId = getBody('get')['id'];
}

if(!empty(getBody('get')['action_old'])) {
   $actionOld = getBody('get')['action_old'];
}

$styleFont = "";

if(!empty($actionOld)) {
   $styleFont = "font-family: latha, DejaVu Sans, sans-serif;";
}

$listAllReportDefects = getRaw("SELECT rd.id, df.name, rd.level, df.skip, rd.defect_id, df.cate_id, (SELECT name FROM defect_categories WHERE df.cate_id = id) AS cate_defect_name, rd.defect_quantity, rd.note, rd.create_at FROM report_defect as rd JOIN defects as df ON df.id = rd.defect_id WHERE rd.report_id = $reportId ORDER BY cate_defect_name DESC");

// echo '<pre>';
// print_r($listAllReportDefects);
// echo '</pre>';

$report = firstRaw("SELECT rp.po_code, rp.code_report, rp.defect_finder, rp.quantity_deliver, rp.quantity_inspect, rp.comment, rp.suggest, rp.user_id, rp.create_at, rp.deduction, rp.status, rs.userXX, rs.userQD, rs.userPD, rs.userGC, rs.sign_text_GC, f.name AS factory_name, p.name AS product_name, rp.create_at FROM reports AS rp JOIN factories AS f ON f.id = rp.factory_id JOIN products AS p ON p.id = rp.product_id JOIN report_sign AS rs ON report_id = rp.id WHERE rp.id = $reportId");

$sign_userKT = !empty(firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $report["user_id"])['sign_text']) ? firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $report["user_id"])['sign_text'] : false;
$fullnameUserKT = firstRaw("SELECT fullname FROM users WHERE id = ". $report["user_id"])['fullname'];

$userXX = json_decode($report["userXX"]);
$userQD = json_decode($report["userQD"]);
$userPD = json_decode($report["userPD"]);
$userGC = json_decode($report["userGC"]);

$fullnameGC = null;
$sign_at_GC = null;
$sign_text_GC = null;
$deduction = !empty($report["deduction"]) ? json_decode($report["deduction"], true) : false;

if(!empty($userGC)) {
   if(!empty($userGC->fullname)) {
      $fullnameGC = $userGC->fullname;
   }
   if(!empty($userGC->sign_at)) {
      $sign_at_GC = $userGC->sign_at;
   }
   if(!empty($report["sign_text_GC"])) {
      $sign_text_GC = $report["sign_text_GC"];
   }
}

/**
 * 1: userId là người tạo
 * 2: userId là người ký
 * 3: userId là người ngoài hoặc người đã ký (thực hiện cho chức năng seen all ở permissions)
 */
if(empty($actionOld)) {
   $statusSign = 3; 
   if(($userId == $userXX->user_id && $userXX->status == 2) || ($userId == $userQD->user_id && $userQD->status == 2) || ($userId == $userPD->user_id && $userPD->status == 2)) {
      $statusSign = 2;
   }
   if($userId == $report['user_id']) {
      $statusSign = 1;
   }
}

$sign_userXX = !empty(firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $userXX->user_id)['sign_text']) ? firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $userXX->user_id)['sign_text'] : false;
$fullnameUserXX = firstRaw("SELECT fullname FROM users WHERE id = ". $userXX->user_id)['fullname'];

$sign_userQD = !empty(firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $userQD->user_id)['sign_text']) ? firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $userQD->user_id)['sign_text'] : false;
$fullnameUserQD = firstRaw("SELECT fullname FROM users WHERE id = ". $userQD->user_id)['fullname'];

$sign_userPD = !empty(firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $userPD->user_id)['sign_text']) ? firstRaw("SELECT sign_text FROM sign WHERE user_id = ". $userPD->user_id)['sign_text'] : false;
$fullnameUserPD = firstRaw("SELECT fullname FROM users WHERE id = ". $userPD->user_id)['fullname'];

$status_userXX = $userXX->status;
$status_userQD = $userQD->status;
$status_userPD = $userPD->status;

$resultAQL = firstRaw("SELECT * FROM resultaql WHERE report_id = $reportId");
$dateCreateStr = $report['create_at'];

$dateCreate = new DateTime($dateCreateStr);
$year = $dateCreate->format('Y');
$month = $dateCreate->format('m');
$day = $dateCreate->format('d');


$separatedArrays = [];

foreach($listAllReportDefects as $item) {
   $cateDefectName = $item['cate_defect_name'];

   if(!isset($separatedArrays[$cateDefectName])) {
      $separatedArrays[$cateDefectName] = [];
   }

   $separatedArrays[$cateDefectName][] = $item;
}  

$listDefectImageId = [];
$rowMaxOnPage = 10;
 ?>

<div class="container content-pdf">
   <table class="table table-bordered mb-0">
      <tbody>
         <tr>
            <td width="20%">
               <img
                  src="<?php echo "data:image/png;base64,".base64_encode(file_get_contents(_WEB_HOST_ROOT_ADMIN.'/images/logo-kd-blue-1.png')) ?>"
                  alt="logo" width="200" height="100">
            </td>
            <td width="50%" style="text-align: center; vertical-align: middle;">
               <h2 class="flex-1 text-center" style="$styleFont">BIÊN BẢN KIỂM TRA
                  CHẤT LƯỢNG MAY ĐẦU VÀO</h2>
            </td>
            <td width="30%">
               <p class="mb-0" style="$styleFont">Số hiệu: BBKTCL-BM01</p>
               <p class="mb-0" style="$styleFont">Ngày hiệu lực: 15/03/2023</p>
               <p class="mb-0" style="$styleFont">Lần ban hành: 01</p>
            </td>
         </tr>
         <tr>
            <td colspan=2>
               <p style="$styleFont">Số: <?php echo $report['code_report'] ?></p>
            </td>
            <td width="30%">
               <p style="$styleFont">
                  Ngày lập: <?php echo $day ?> tháng <?php echo $month ?> năm <?php echo $year ?>
               </p>
            </td>
         </tr>
      </tbody>
   </table>
   <table class="table table-bordered mb-0">
      <tbody>
         <tr>
            <td colspan="2" width="40%">
               <b style="$styleFont">Tên cơ sở:</b>
               <p style="display: inline;$styleFont">
                  <?php echo $report['factory_name'] ?></p>
            </td>
            <td colspan="2" width="60%">
               <b style="$styleFont">Tên sản phẩm:</b>
               <p style="display: inline; $styleFont">
                  <?php echo $report['product_name'] ?></p>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <b style="$styleFont">Người phát hiện:</b>
               <p style="display: inline; $styleFont">
                  <?php echo $report['defect_finder'] ?></p>
            </td>
            <td colspan="2">
               <b style="$styleFont">Số Po/Lot:</b>
               <p style="display: inline; $styleFont"><?php echo $report['po_code'] ?>
               </p>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <b style="$styleFont">Số lượng giao:</b>
               <p style="display: inline; $styleFont">
                  <?php echo $report['quantity_deliver'] ?></p>
            </td>
            <td colspan="2">
               <b style="$styleFont">Số lượng kiểm:</b>
               <p style="display: inline; $styleFont">
                  <?php echo $report['quantity_inspect'] ?></p>
            </td>
         </tr>
         <tr>
            <td rowspan="4" width="13%" style="text-align: left; vertical-align: middle;"><b style="$styleFont">Kết quả
                  AQL</b></td>
            <td width="21%"><b style="$styleFont">AQL 2.5-4.0 Level II</b></td>
            <td width="19.5%" class="text-center"><b style="$styleFont">Số lỗi tối đa
                  cho phép</b></td>
            <td class="text-center" width="27.54%"><b style="$styleFont">Số lỗi thực
                  tế</b></td>
         </tr>
         <tr>
            <td><b style="$styleFont">Nghiêm trọng</b></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_serious_accept'] ?></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_serious_real'] ?></td>
         </tr>
         <tr>
            <td><b style="$styleFont">Nặng</b></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_heavy_accept'] ?></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_heavy_real'] ?></td>
         </tr>
         <tr>
            <td><b style="$styleFont">Nhẹ</b></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_light_accept'] ?></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_light_real'] ?></td>
         </tr>
      </tbody>
   </table>
   <table class="table table-bordered">
      <thead>
         <tr class="text-center">
            <td width="6%" style="$styleFont"><b>STT</b></td>
            <td width="50%" colspan="2"><b style="$styleFont">Nội dung lỗi</b></td>
            <td width="11%"><b style="$styleFont">Mức độ</b></td>
            <td width="13%"><b style="$styleFont">Nghiêm trọng</b></td>
            <td width="8%"><b style="$styleFont">Lỗi nặng</b></td>
            <td width="8%"><b style="$styleFont">Lỗi nhẹ</b></td>
            <td <?php echo (!empty($actionOld)) ? 'colspan="2"' : false; ?>><b style="$styleFont">Ghi chú</b></td>
            <?php echo (empty($actionOld)) ? '<td width="5%" style="$styleFont"><b>Ảnh</b></td>' : false; ?>
         </tr>
      </thead>
      <tbody>
         <?php 
            if(!empty($separatedArrays)):
               // echo '<pre>';
               // print_r($separatedArrays);
               // echo '</pre>';
               $count = 0;
               $countItem = 0;
               foreach($separatedArrays as $key=>$value):
                  $count++;
                  $countRows = count($value);
                  $isFirst = true;
                  foreach($value as $item):
                     if($item["skip"] == 0):
         ?>
         <tr>
            <?php echo ($isFirst) ? '<td class="text-center" style="vertical-align: middle; $styleFont" rowspan="'.$countRows.'">'.$count.'</td>' : '' ?>
            <?php echo ($isFirst) ? '<td rowspan="'.$countRows.'" style="text-align: center; vertical-align: middle; $styleFont" width="10%">'.$key.'</td>' : '';  $isFirst = false?>
            <td width="26%" style="vertical-align: middle; $styleFont">
               <?php echo $item['name'] ?></td>
            <td class="text-center" style="vertical-align: middle; $styleFont">
               <?php 
               $level =  $item['level'];
               echo $level;
               ?>
            </td>
            <td class="text-center" style="vertical-align: middle; $styleFont">
               <?php echo ($level == 'Nghiêm trọng') ? $item['defect_quantity'] : false ?></td>
            <td class="text-center" style="vertical-align: middle; $styleFont">
               <?php echo ($level == 'Nặng') ? $item['defect_quantity'] : false ?></td>
            <td class="text-center" style="vertical-align: middle; $styleFont">
               <?php echo ($level == 'Nhẹ') ? $item['defect_quantity'] : false ?></td>
            <td style="vertical-align: middle; $styleFont" <?php echo (!empty($actionOld)) ? 'colspan="2"' : false; ?>>
               <?php echo $item['note'] ?></td>
            <?php
               if(empty($actionOld)) {
                  echo '<td><a href="'.getLinkAdmin('reports', 'seen_images_defect', ['report_id'=>$reportId, 'report_defect_id'=>$item['id']]).'" class="btn btn-success"><i class="far fa-eye"></i></a></td>';
               } else {
                  $listDefectImageId[] = ['report_id'=>$reportId, 'report_defect_id'=>$item['id']];
               }
            ?>
         </tr>
         <?php 
                     endif;
                  endforeach;
               endforeach;
            endif;
         ?>
         <tr>
            <td colspan="3" class="text-center"><b style="$styleFont">Tổng cộng</b>
            </td>
            <td class="text-center" style="$styleFont"></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_serious_real'] ?></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_heavy_real'] ?></td>
            <td class="text-center" style="$styleFont">
               <?php echo $resultAQL['quantity_light_real'] ?></td>
            <td <?php echo (!empty($actionOld)) ? 'colspan="2"' : false; ?>></td>
         </tr>
         <tr>
            <td colspan="2"><b>Kết luận:</b></td>
            <td class="text-center" style="$styleFont"><i
                  class="far <?php echo ($resultAQL['conclusion'] == 2) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>ĐẠT
            </td>
            <td colspan="2" class="text-center" style="$styleFont"><i
                  class="far <?php echo ($resultAQL['conclusion'] == 1) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>KHÔNG
               ĐẠT</td>
            <td <?php echo (!empty($actionOld)) ? 'colspan="4"' : 'colspan="3"'; ?> class="text-center"
               style="$styleFont"><i
                  class="far <?php echo ($resultAQL['conclusion'] == 3) ? 'fa-check-square' : 'fa-square' ?> mr-2"></i>CHỜ
               XỬ LÝ</td>
         </tr>
      </tbody>
   </table>

   <b style="$styleFont">Nhận xét/Yêu cầu của QC:</b>
   <p style="$styleFont">
      <?php echo (!empty($report['comment'])) ? $report['comment'] : '............................................................................................................................................................................................................................................................................................................................................' ?>
   </p>

   <b style="$styleFont">Hướng xử lý (Đối với trường hợp không đạt):</b>
   <p id="content_suggest" style="$styleFont">
      <?php 
         if(!empty($report['deduction'])) {
            $deduction = json_decode($report['deduction'], true);
            $value = $deduction['value'];
            $unit = $deduction['unit'];

            echo "Trừ ". number_format($value)." ".$unit."<br>";
         }
      ?>
      <?php echo (!empty($report['suggest'])) ? $report['suggest'] : '............................................................................................................................................................................................................................................................................................................................................' ?>
   </p>

   <table class="table">
      <tr>
         <td width="20%" class="text-center"><b style="$styleFont">Người kiểm tra</b>
         </td>
         <td width="20%" class="text-center"><b style="$styleFont">Công sở gia
               công</b></td>
         <td width="20%" class="text-center"><b style="$styleFont">Người xem xét</b>
         </td>
         <td width="20%" class="text-center"><b style="$styleFont">QĐ/PQĐ</b></td>
         <td width="20%" class="text-center"><b style="$styleFont">Người phê duyệt</b>
         </td>
      </tr>
      <!-- Thêm chữ ký đã xác nhận ký -->
      <tr>
         <td>
            <?php echo !empty($sign_userKT) ? '<img src="'.$sign_userKT.'" alt="" class="sign"><p class="d-block text-center mt-2">'.$fullnameUserKT.'</p><p class="d-block text-center">'.getDateFormat($report['create_at'], 'd-m-Y H:i:s').'</p>' : false ?>
         </td>
         <td id="sign_GC_content">
            <?php echo !empty($sign_text_GC) ? '<img src="'.$sign_text_GC.'" alt="" class="sign"><p class="d-block text-center mt-2" style="$styleFont">'.$fullnameGC.'</p><p class="d-block text-center" style="$styleFont">'.getDateFormat($sign_at_GC, 'd-m-Y H:i:s').'</p>' : false ?>
         </td>
         <td>
            <?php echo !empty($sign_userXX) && $status_userXX == 1 ? '<img src="'.$sign_userXX.'" alt="" class="sign"><p class="d-block text-center mt-2" style="$styleFont">'.$fullnameUserXX.'</p><p class="d-block text-center" style="$styleFont">'.getDateFormat($userXX->sign_at, 'd-m-Y H:i:s').'</p>' : false ?>
         </td>
         <td>
            <?php echo !empty($sign_userQD) && $status_userQD == 1 ? '<img src="'.$sign_userQD.'" alt="" class="sign"><p class="d-block text-center mt-2" style="$styleFont">'.$fullnameUserQD.'</p><p class="d-block text-center" style="$styleFont">'.getDateFormat($userQD->sign_at, 'd-m-Y H:i:s').'</p>' : false ?>
         </td>
         <td>
            <?php echo !empty($sign_userPD) && $status_userPD == 1 ? '<img src="'.$sign_userPD.'" alt="" class="sign"><p class="d-block text-center mt-2" style="$styleFont">'.$fullnameUserPD.'</p><p class="d-block text-center" style="$styleFont">'.getDateFormat($userPD->sign_at, 'd-m-Y H:i:s').'</p>' : false ?>
         </td>
      </tr>
   </table>
   <?php 
   if(empty($actionOld)): 
      if($isSignGC):
   ?>
   <div>
      <hr>
      <label for="sign_GC">Chữ ký nhà gia công: (<i class="error">Nhớ bấm xác nhận trước khi Lưu</i>)</label>
      <!-- Signature -->
      <div id="sign_GC"></div>
      <small class="error" id="error_sign_GC"></small>
      <br>

      <label for="fullname_GC">Tên người ký nhà gia công:</label>
      <input type="text" class="form-control" placeholder="Tên người ký..." name="fullname_GC" id="fullname_GC"
         value="<?php echo !empty($fullnameGC) ? $fullnameGC : false ?>"
         <?php echo !empty($fullnameGC) ? "disabled" : false ?>>
      <small class="error" id="error_fullname_GC"></small>

      <div class="d-flex mt-2">
         <button id="disable_GC" class="btn btn-info mr-2">Xác nhận</button>
         <button id="clear_GC" class="btn btn-secondary">Làm mới</button>
      </div>
      <input type="hidden" id="sign-text_GC" name="sign-text"
         value="<?php echo !empty($sign_text_GC) ? $sign_text_GC : false ?>">
      <input type="hidden" id="report_id" value="<?php echo $reportId ?>">
      <hr>
   </div>
   <?php 
      endif;
      if($isChangeStatus):
   ?>
   <div class="form-group">
      <label for="chang_status">Trạng thái</label>
      <select name="status" id="chang_status" class="form-control">
         <option value="1" <?php echo ($report['status'] == 1) ? 'selected' : false ?>>Đang xử lý</option>
         <option value="2" <?php echo ($report['status'] == 2) ? 'selected' : false ?>>Chấp nhận</option>
         <option value="3" <?php echo ($report['status'] == 3) ? 'selected' : false ?>>Trả sửa</option>
         <option value="4" <?php echo ($report['status'] == 4) ? 'selected' : false ?>>Nhận tiền trừ</option>
         <option value="5" <?php echo ($report['status'] == 5) ? 'selected' : false ?>>Chưa duyệt</option>
      </select>
   </div>
   <div class="row d-none" id="deduction-content">
      <div class="col-9">
         <div class="form-group">
            <label for="deduction">Số trừ tiền</label>
            <?php 
               if(!empty($deduction)) {
                  $deductionValue = $deduction['value'];
                  $unit = $deduction['unit'];
               }
            ?>
            <input type="text" name="deduction" id="deduction" placeholder="Nhập số trừ tiền"
               value="<?php echo !empty($deductionValue) ? $deductionValue : false ?>" class="form-control">
            <small class="error" id="deduction-error"></small>
         </div>
      </div>
      <div class="col-3">
         <div class="form-group">
            <label for="unit">Đơn vị</label>
            <select name="unit" id="unit" class="form-control">
               <option value="%" <?php echo !empty($unit) && $unit == "%" ? "selected" : false ?>>%</option>
               <option value="VNĐ" <?php echo !empty($unit) && $unit == "VNĐ" ? "selected" : false ?>>VNĐ</option>
            </select>
            <small class="error" id="unit-error"></small>
         </div>
      </div>
   </div>
   <div class="form-group">
      <label for="suggest">Hướng xử lý (Đối với trường hợp không đạt)</label>
      <textarea name="suggest" id="add_suggest" class="form-control" cols="30"
         rows="10"><?php echo !empty($report['suggest']) ? $report['suggest'] : false ?></textarea>
   </div>
   <div>
      <button type="button" class="btn btn-info" id="btnAddSuggest">Xác nhận</button>
      <input type="hidden" id="report_id" value="<?php echo $reportId ?>">
   </div>
   <hr>
   <?php endif; endif?>
   <br>
</div>

<?php if(!empty($actionOld)):?>
<?php
   if(!empty($listDefectImageId)):
      foreach($listDefectImageId as $item):
         $reportDefectId = $item['report_defect_id'];
         $reportId = $item['report_id'];
         require('seen_images_defect.php');
      endforeach;
   endif;
?>
<?php endif;?>
<?php  layout('footer-none','admin'); ?>
<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Chứa chức năng chỉnh danh mục sản phẩm
 */
$data = [
   'title' => 'Chỉnh sửa lỗi của biên bản'
];

   layout('header', 'admin', $data);
   layout('sidebar', 'admin', $data);
   layout('breadcrumb', 'admin', $data);  

 // Xử lý 
 $listAllDefectCates = getRaw("SELECT id, name FROM defect_categories");
 $listAllDefects = getRaw("SELECT id, name FROM defects");

if(isGet()) {
   $defectId = trim(getBody()['id']);
   $reportId = trim(getBody()['report_id']);
   
   if(!empty($defectId)) {
      $defaultProduct = firstRaw("SELECT name, cate_id FROM products WHERE id = '$defectId'");
      setFlashData('defaultProduct', $defaultProduct);
   } else {
      redirect("admin/san-pham");
   }
}

 if(isPost()) {
   //Validate form
   $body = getBody(); //lấy tất cả dữ liệu trong form

   $errors = []; // mãng lưu trữ các lỗi

   $defectQuatity = trim($body['defect_quantity']);
   $cateDefectId = trim($body['cate_defect_id']);
   $defectId = trim($body['defect_id']);
   $reportDefectNote = trim($body['report_defect_note']);

   if(empty($defectQuatity)) {
      $errors['defect_quantity']['required'] = 'Số lượng lỗi không được để trống';
   } else {
      if(!isNumberInt($defectQuatity)) {
         $errors['defect_quantity']['isNum'] = 'Dữ liệu nhập vào phải là số';
      }
   }
   if(empty($cateDefectId)) {
      $errors['cate_defect_id']['required'] = 'Vui lòng chọn danh mục lỗi';
   } 

   if(empty($defectId)) {
      $errors['defect_id']['required'] = 'Vui lòng chọn lỗi';
   } 
   if(empty($errors)) {
      // Không có lỗi xảy ra
      $dataUpdate = [
         'name' => $name,
         'cate_id' => $cateId,
         'update_at' => date('Y-m-d H:i:s'),
      ];

      $updateStatus = update('products', $dataUpdate, "id=$defectId");
      if($updateStatus) {
            setFlashData('msg', 'Chỉnh sửa sản phẩm thành công.');
            setFlashData('msg_type', 'success');
      } else {
         setFlashData('msg', 'Lỗi hệ thống. Vui lòng thử lại sau.');
         setFlashData('msg_type', 'danger');
      }
      redirect('admin/san-pham');
      
   } else {
      setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào!');
      setFlashData('msg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $body);
      redirect("admin/san-pham/chinh-sua/id=$defectId");
   }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$defaultProduct = getFlashData('defaultProduct');
if(!empty($defaultProduct)) {
   $old = $defaultProduct;
}
 ?>
<div class="container">
   <div class="row">
      <?php 
            getMsg($msg, $msgType);
         ?>
      <div class="col-12">
         <form action="" method="post" class='flex-1 col-12' enctype="multipart/form-data">
            <div class="col-12">
               <div class="row">
                  <div class="col-4 d-flex">
                     <div class="form-group flex-1">
                        <label for="select_cate_report_defect_add">Chọn danh mục lỗi</label>
                        <div class="d-flex">
                           <select name="select_cate_report_defect_add" id="select_cate_report_defect_add"
                              class="form-control mw-210" readonly disabled>
                              <option value="0">Chọn danh mục lỗi</option>
                              <?php 
                                        if(!empty($listAllDefectCates)):
                                           foreach($listAllDefectCates as $defectCate):
                                     ?>
                              <option value="<?php echo $defectCate['id'] ?>"
                                 <?php echo (!empty($cateDefectId) && $defectCate['id'] == $cateDefectId) ? 'selected' : false ?>>
                                 <?php echo $defectCate['name']?>
                              </option>
                              <?php 
                                           endforeach;
                                        endif;
                                     ?>
                           </select>
                           <input type="hidden" name="cate_defect_id" id="cate_defect_id">
                           <button type="button" class="btn btn-secondary" data-toggle="modal"
                              data-target="#chooseCateDefectNameAdd">
                              <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                           </button>
                        </div>
                        <?php echo form_error('cate_defect_id', $errors, '<span class="error">', '</span>') ?>
                     </div>


                     <!-- Modal -->
                     <!-- data-backdrop="static" -->
                     <div class="modal fade" id="chooseCateDefectNameAdd" data-keyboard="false" tabindex="-1"
                        aria-labelledby="chooseCateDefectNameAddLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="chooseCateDefectNameAddLabel">Danh sách danh mục</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <!-- <form action="" method="POST"> -->
                                 <div class="row justify-content-center mb-8">
                                    <div class="col-6">
                                       <input type="text" class="form-control" id="keyword_modal" name="keyword_modal"
                                          placeholder="Nhập tên lỗi...">
                                    </div>
                                    <div class="col-3">
                                       <button type="button" id="btnSearchModal" class="btn btn-success">Tìm
                                          kiếm</button>
                                    </div>
                                 </div>
                                 <hr>
                                 <!-- </form> -->
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                          <th width="5%">STT</th>
                                          <th>Tên</th>
                                          <th width="15%">Chọn</th>
                                       </tr>
                                    </thead>
                                    <tbody id="content_modal">
                                       <?php 
                                                          $body = getBody();
                                                          if(!empty($body['defect_id'])) {
                                                             $defectId = $body['defect_id'];
                                                          } else {
                                                             $defectId = '';
                                                          }
                                                          if(!empty($body['report_defect_note'])) {
                                                             $reportDefectNote = $body['report_defect_note'];
                                                          } else {
                                                             $reportDefectNote = '';
                                                          }
                
                                                          if(!empty($listAllDefectCates)):
                                                             $count = 0;
                                                             foreach($listAllDefectCates as $defectCategory):
                                                                $count++;
                                                       ?>
                                       <tr>
                                          <td><?php echo $count ?></td>
                                          <td>
                                             <?php
                                                                echo $defectCategory['name']
                                                             ?>
                                          </td>
                                          <td class="text-center">
                                             <a class="btn btn-success" href="
                                                                <?php
                                                                   echo getLinkAdmin('reports', 'edit', ['defect_id'=>$defectId,  'report_defect_note'=>$reportDefectNote, 'cate_defect_id' =>$defectCategory["id"], 'id' => $reportId]) 
                                                                ?>">
                                                Chọn
                                             </a>
                                          </td>
                                       </tr>
                                       <?php 
                                                          endforeach; else:
                                                       ?>
                                       <tr>
                                          <td colspan="4" class="text-center alert alert-danger">Không có danh mục
                                          </td>
                                       </tr>
                                       <?php endif; ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
                                 <a href="<?php echo getLinkAdmin('reports','edit', ['id'=>$reportId]) ?>" type="button"
                                    class="btn btn-danger">Hủy chọn</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-4 d-flex">
                     <div class="form-group flex-1">
                        <label for="select_name_defect_add">Chọn lỗi</label>
                        <div class="d-flex">
                           <select name="select_name_defect_add" id="select_name_defect_add" class="form-control mw-210"
                              readonly disabled>
                              <option value="0">Chọn tên lỗi</option>
                              <?php 
                                        if(!empty($listAllDefects)):
                                           foreach($listAllDefects as $defect):
                                     ?>
                              <option value="<?php echo $defect['id'] ?>"
                                 <?php echo (!empty($defectId) && $defect['id'] == $defectId) ? 'selected' : false ?>>
                                 <?php echo $defect['name']?>
                              </option>
                              <?php 
                                           endforeach;
                                        endif;
                                     ?>
                           </select>
                           <input type="hidden" name="defect_id" id="defect_id">
                           <button type="button" class="btn btn-secondary" data-toggle="modal"
                              data-target="#chooseDefectNameAdd">
                              <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                           </button>
                        </div>
                        <?php echo form_error('defect_id', $errors, '<span class="error">', '</span>') ?>
                     </div>


                     <!-- Modal -->
                     <!-- data-backdrop="static" -->
                     <div class="modal fade" id="chooseDefectNameAdd" data-keyboard="false" tabindex="-1"
                        aria-labelledby="chooseDefectNameAddLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="chooseDefectNameAddLabel">Danh sách tên lỗi</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <!-- <form action="" method="POST"> -->
                                 <div class="row justify-content-center mb-8">
                                    <div class="col-6">
                                       <input type="text" class="form-control" id="keyword_modal" name="keyword_modal"
                                          placeholder="Nhập tên lỗi...">
                                    </div>
                                    <div class="col-3">
                                       <button type="button" id="btnSearchModal" class="btn btn-success">Tìm
                                          kiếm</button>
                                    </div>
                                 </div>
                                 <hr>
                                 <!-- </form> -->
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                          <th width="5%">STT</th>
                                          <th>Tên</th>
                                          <th width="15%">Chọn</th>
                                       </tr>
                                    </thead>
                                    <tbody id="content_modal">
                                       <?php 
                                                          $body = getBody('get');
                                                          if(!empty($body['cate_defect_id'])) {
                                                             $cateDefectId = $body['cate_defect_id'];
                                                          } else {
                                                             $cateDefectId = '';
                                                          }
                                                          if(!empty($body['report_defect_note'])) {
                                                             $reportDefectNote = $body['report_defect_note'];
                                                          } else {
                                                             $reportDefectNote = '';
                                                          }
                
                                                          if(!empty($listAllDefects)):
                                                             $count = 0;
                                                             foreach($listAllDefects as $defect):
                                                                $count++;
                                                       ?>
                                       <tr>
                                          <td><?php echo $count ?></td>
                                          <td>
                                             <?php
                                                                echo $defect['name']
                                                             ?>
                                          </td>
                                          <td class="text-center">
                                             <a class="btn btn-success" href="
                                                                <?php
                                                                   echo getLinkAdmin('reports', 'report_defect_edit', ['id'=>$defect["id"],  'report_defect_note'=>$reportDefectNote, 'cate_defect_id' =>$cateDefectId, 'id' => $reportId]) 
                                                                ?>">
                                                Chọn
                                             </a>
                                          </td>
                                       </tr>
                                       <?php 
                                                          endforeach; else:
                                                       ?>
                                       <tr>
                                          <td colspan="4" class="text-center alert alert-danger">Không có lỗi
                                          </td>
                                       </tr>
                                       <?php endif; ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">Thoát</button>
                                 <a href="<?php echo getLinkAdmin('reports','edit', ['id'=>$reportId]) ?>" type="button"
                                    class="btn btn-danger">Hủy chọn</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="form-group">
                        <label for="defect_quantity">Số lượng lỗi</label>
                        <input type="text" name="defect_quantity" id="defect_quantity" class="form-control"
                           placeholder="Nhận số lượng lỗi..." value="<?php echo old('defect_quantity', $oldAdd)?>">
                        <?php echo form_error('defect_quantity', $errors, '<span class="error">', '</span>') ?>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="form-group">
                        <label for="file">Chọn ảnh</label>
                        <input type="file" name="files[]" id="file" class="form-control" multiple>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="report_defect_note">Ghi chú</label>
                        <textarea name="report_defect_note" id="report_defect_note" class="form-control"
                           placeholder="Nhập ghi chú..."><?php echo old('report_defect_note', $oldAdd)?></textarea>
                     </div>
                  </div>
                  <input type="hidden" name="module" value="reports">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="cate_defect_id"
                     value="<?php echo (!empty($cateDefectId)) ? $cateDefectId : false ?>">
                  <input type="hidden" name="defect_id" value="<?php echo (!empty($defectId)) ? $defectId : false ?>">
                  <input type="hidden" name="id" value="<?php echo $reportId ?>">
                  <div class="col-2">
                     <br>
                     <br>
                     <button type="submit" class="btn btn-primary btn-block">Thêm</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>

</div>

<?php
  layout('footer','admin');
 ?>
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
   $isEdit = true;
   $isDelete = true;
   $isExport = true;
   $isSeen = true;
   $isSeenAll = true;
} else {
   $permissionData = getPermissionData($groupId);
   $checkPermission = checkPermission($permissionData, 'reports', 'lists');
   $isEdit = checkPermission($permissionData, 'reports', 'edit');
   $isDelete = checkPermission($permissionData, 'reports', 'delete');
   $isExport = checkPermission($permissionData, 'reports', 'export');
   $isSeen = checkPermission($permissionData, 'reports', 'seen');
   $isSeenAll = checkPermission($permissionData, 'reports', 'seen_all');
}

if(!$checkPermission) {
  setFlashData('msg', 'Bạn không có quyền truy cập vào trang Quản lý biên bản');
  setFlashData('msg_type', 'danger');
  redirect("admin/");
}
   $data = [
      'title' => 'Danh Sách Biên Bản'
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

   $listAllUsers = getRaw("SELECT id, fullname, phone FROM users ORDER BY create_at DESC");
   $listAllCates = getRaw("SELECT id, name, code_category FROM report_categories ORDER BY create_at DESC");
   $listAllFactories = getRaw("SELECT id, name FROM factories ORDER BY create_at DESC");
   $listAllProducts = getRaw("SELECT id, name FROM products ORDER BY create_at DESC");
   $listResultAQL = [
      'Đạt',
      'Không đạt',
      'Chờ xử lý'
   ];
   $listChooses = [
      '0'=>'Chọn trường muốn tìm kiếm',
      'rp_c.name'=>'Danh mục biên bản',
      'u.fullname'=>'Người tạo',
      'f.name'=>'Cơ sở',
      'p.name'=>'Sản phẩm',
      'po_code'=>'Số PO/Lot'
   ];

   $user_id = isLogin()['user_id'];
   $signText = firstRaw("SELECT sign_text FROM sign WHERE user_id = $user_id");

// Xử lý tìm kiếm
$filter = '';
if(isGet()) {
   if(!empty(getBody()["choose"])) {
      $choose = trim(getBody()["choose"]);
   }

   if(!empty(getBody()["keyword"])) {
      $keyword = trim(getBody()["keyword"]);
      if(empty($choose)) {
         $filter .= " WHERE rp_c.name LIKE '%$keyword%'";   
      } else {
         $filter .= " WHERE $choose LIKE '%$keyword%'";   
      }
   }

   if(!empty(getBody()["cate_id"])) {
      $cateId = trim(getBody()["cate_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator rp.cate_id = $cateId"; 
   }
   if(!empty(getBody()["user_id"])) {
      $userId = trim(getBody()["user_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator rp.user_id = $userId"; 
   }
   if(!empty(getBody()["factory_id"])) {
      $factoryId = trim(getBody()["factory_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator factory_id = $factoryId"; 
   }
   if(!empty(getBody()["product_id"])) {
      $productId = trim(getBody()["product_id"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator product_id = $productId"; 
   }
   if(!empty(getBody()["conclusion"])) {
      $conclusion = trim(getBody()["conclusion"]);
      if(empty($filter)) {
         $operator = ' WHERE';
      } else {
         $operator = ' AND';
      }
      $filter .= "$operator conclusion = $conclusion"; 
   }
   if(!empty(getBody()["status"])) {
      $statusSign = trim(getBody()["status"]);
   }
}

// Xử lý phân trang
$countRowReports = 0;

// Số lượng trang
$listAllReports = getRaw("SELECT rp.id, rp.cate_id, rp.user_id, rp.factory_id, rp.product_id, rp.status, rp_c.name AS name_cate, rs.userXX, rs.userQD, rs.userPD, u.fullname AS name_user, f.name AS name_factory, p.name AS name_product, po_code, conclusion, code_report, rp.create_at FROM reports AS rp JOIN report_categories AS rp_c ON rp.cate_id = rp_c.id JOIN users AS u ON rp.user_id = u.id JOIN factories AS f ON rp.factory_id = f.id JOIN products AS p ON rp.product_id = p.id JOIN resultaql AS ra ON rp.id = ra.report_id JOIN report_sign AS rs ON rs.report_id = rp.id $filter ORDER BY rp.create_at DESC");

// echo '<pre>';
// print_r($listAllReports);
// echo '</pre>';

$listReportOnPage = [];
if(!$isSeenAll) {
   foreach($listAllReports as $report) {
      $statusReport = $report['status'];
      if($user_id == $report['user_id']) {
         if(!empty($signText)) {
            $report["status_text"] = '<span class="ml-2 btn btn-success">Đã ký</span>';
            if(empty($statusSign) || $statusSign == 1) {
               $listReportOnPage[] = $report;
            }
         } else {
            $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
            $listReportOnPage[] = $report;
         }
      } else {
         if($statusReport != 5) {
            $userXX = json_decode($report['userXX'], true);
            $userQD = json_decode($report['userQD'], true);
            $userPD = json_decode($report['userPD'], true);
            $statusKT = !empty(firstRaw("SELECT sign_text FROM sign WHERE user_id =".$report['user_id'])) ? 1 : 2;
            $statusXX = $userXX['status'];
            $statusQD = $userQD['status'];
   
            if(!empty($userXX["user_id"]) && $userXX["user_id"] == $user_id) {
               $status = $userXX["status"];
               if($statusKT == 1) {
                  if($status == 1 && !empty($signText)) {
                     $report["status_text"] ='<span class="btn btn-success">Đã ký</span>';
                     $statusXX = 1;
                     if(empty($statusSign) || $statusSign == 1) {
                        $listReportOnPage[] = $report;
                     }
                  } else if(($status == 1 && empty($signText)) || ($status == 2 && empty($signText))) {
                     $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
                     $listReportOnPage[] = $report;
                  } else if($status == 2 && !empty($signText)) {
                     $report["status_text"] = ["status" => "Ký ngay"];
                     if(empty($statusSign) || $statusSign == 2) {
                        $listReportOnPage[] = $report;
                     }
                  }
               }
            }
   
            if(!empty($userQD["user_id"]) && $userQD["user_id"] == $user_id) {
               $status = $userQD["status"];
               if($statusKT == 1) {
                  if($status == 1 && !empty($signText)) {
                     $report["status_text"] ='<span class="ml-2 btn btn-success">Đã ký</span>';
                     $statusQD = 1;
                     if(empty($statusSign) || $statusSign == 1) {
                        $listReportOnPage[] = $report;
                     }
                  } else if(($status == 1 && empty($signText)) || ($status == 2 && empty($signText))) {
                     $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
                     $listReportOnPage[] = $report;
                  } else if($status == 2 && !empty($signText)) {
                     $report["status_text"] = ["status" => "Ký ngay"];
                     if(empty($statusSign) || $statusSign == 2) {
                        $listReportOnPage[] = $report;
                     }
                  }
               }
            }
   
            if(!empty($userPD["user_id"]) && $userPD["user_id"] == $user_id) {
               $status = $userPD["status"];
               if($statusXX == 1 || $statusQD == 1) {
                  if($status == 1 && !empty($signText)) {
                     $report["status_text"] ='<span class="ml-2 btn btn-success">Đã ký</span>';
                     if(empty($statusSign) || $statusSign == 1) {
                        $listReportOnPage[] = $report;
                     }
                  } else if(($status == 1 && empty($signText)) || ($status == 2 && empty($signText))) {
                     $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
                     $listReportOnPage[] = $report;
                  } else if($status == 2 && !empty($signText)) {
                     $report["status_text"] = ["status" => "Ký ngay"];
                     if(empty($statusSign) || $statusSign == 2) {
                        $listReportOnPage[] = $report;
                     }
                  }
               }
            }
         }
      }
   }
} else {
   foreach($listAllReports as $report) {
      if($user_id == $report['user_id']) {
         if(!empty($signText)) {
            $report["status_text"] = '<span class="ml-2 btn btn-success">Đã ký</span>';
            if(!empty($statusSign) && $statusSign == 1) {
               $listReportOnPage[] = $report;
            }
         } else {
            $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
         }
         if(empty($statusSign)) {
            $listReportOnPage[] = $report;
         }
      } else {
         $userXX = json_decode($report['userXX'], true);
         $userQD = json_decode($report['userQD'], true);
         $userPD = json_decode($report['userPD'], true);
         $statusKT = !empty(firstRaw("SELECT sign_text FROM sign WHERE user_id =".$report['user_id'])) ? 1 : 2;
         $statusXX = 2;
         $statusQD = 2;
         $statusPD = 2;

         if(!empty($userXX["user_id"]) && $userXX["user_id"] == $user_id) {
            $status = $userXX["status"];
            if($statusKT == 1) {
               if($status == 1 && !empty($signText)) {
                  $report["status_text"] ='<span class="ml-2 btn btn-success">Đã ký</span>';
                  if(!empty($statusSign) && $statusSign == 1) {
                     $listReportOnPage[] = $report;
                  }
                  $statusXX = 1;
               } else if(($status == 1 && empty($signText)) || ($status == 2 && empty($signText))) {
                  $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
               } else if($status == 2 && !empty($signText)) {
                  $report["status_text"] = ["status" => "Ký ngay"];
                  if(!empty($statusSign) && $statusSign == 2) {
                     $listReportOnPage[] = $report;
                  }
               }
            }
         }

         if(!empty($userQD["user_id"]) && $userQD["user_id"] == $user_id) {
            $status = $userQD["status"];
            if($statusKT == 1) {
               if($status == 1 && !empty($signText)) {
                  $report["status_text"] ='<span class="ml-2 btn btn-success">Đã ký</span>';
                  $statusQD = 1;
                  if(!empty($statusSign) && $statusSign == 1) {
                     $listReportOnPage[] = $report;
                  }
               } else if(($status == 1 && empty($signText)) || ($status == 2 && empty($signText))) {
                  $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
               } else if($status == 2 && !empty($signText)) {
                  $report["status_text"] = ["status" => "Ký ngay"];
                  if(!empty($statusSign) && $statusSign == 2) {
                     $listReportOnPage[] = $report;
                  }
               }
            }
         }

         if(!empty($userPD["user_id"]) && $userPD["user_id"] == $user_id) {
            $status = $userPD["status"];
            if($statusXX == 1 || $statusQD == 1) {
               if($status == 1 && !empty($signText)) {
                  $report["status_text"] ='<span class="ml-2 btn btn-success">Đã ký</span>';
                  if(!empty($statusSign) && $statusSign == 1) {
                     $listReportOnPage[] = $report;
                  }
               } else if(($status == 1 && empty($signText)) || ($status == 2 && empty($signText))) {
                  $report["status_text"] = '<a href="'.getLinkAdmin('users', 'sign').'" class="ml-2 btn btn-warning">Tạo chữ ký</a>';
               } else if($status == 2 && !empty($signText)) {
                  $report["status_text"] = ["status" => "Ký ngay"];
                  if(!empty($statusSign) && $statusSign == 2) {
                     $listReportOnPage[] = $report;
                  }
               }
            }
         }
         if(empty($statusSign)) {
            $listReportOnPage[] = $report;
         }
      }
   }
}

$countRowReports = count($listReportOnPage);

// Số lượng trang muốn hiển thị trên 1 trang
$reportOnPage = _PAGE_ON_PAGE;

// Số lượng phân trang
$numPage = ceil($countRowReports/$reportOnPage);

// Giới hạn số lượng phân trang
$limitPagination = _LIMIT_PAGINATION;

 $page = 1;
 if(isGet() && !empty($_GET['page'])) {
   $page = $_GET['page'];
   if($page < 1 && $page > $numPage) {
      $page = 1;
   } 
 }

/** Thuật toán phân trang (page - 1) * reportOnPage
 * page = 1 => offset = 0
 * page = 2 => offset = 3
 * page = 3 => offset = 6
 */
$offset = ($page - 1) * $reportOnPage;

//Xử lý query String
$queryStr = '?';
if(!empty($_SERVER["QUERY_STRING"])) {
   $queryStr = $_SERVER["QUERY_STRING"];
   $queryStr = str_replace('module=reports', '', $queryStr);
   $queryStr = str_replace('page='.$page, '', $queryStr);
   $queryStr = trim($queryStr, '&');
   if(!empty($queryStr)) {
      $queryStr = '?'.$queryStr.'&';
   } else {
      $queryStr = '?';

   }
} 

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <?php 
         getMsg($msg, $msgType);
      ?>
      <form action="" method="get">
         <div class="row mb-3">
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
               <div class="form-group">
                  <select name="cate_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Danh mục biên bản" data-width="100%">
                     <option value="0">Chọn tất cả</option>
                     <?php 
                        if(!empty($listAllCates)):
                           foreach($listAllCates as $cate):
                     ?>
                     <option value="<?php echo $cate['id'] ?>"
                        <?php echo (!empty($cateId) && $cate['id'] == $cateId) ? 'selected' : false ?>>
                        <?php echo $cate['name']?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
               <div class="form-group">
                  <select name="user_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Người tạo" data-width="100%">
                     <option value="0">Chọn tất cả</option>
                     <?php 
                        $body = getBody('get');
                        if(!empty($body['cate_id'])) {
                           $cateId = $body['cate_id'];
                        } else {
                           $cateId = '';
                        }
                        if(!empty($body['factory_id'])) {
                           $factoryId = $body['factory_id'];
                        } else {
                           $factoryId = '';
                        }
                        if(!empty($body['product_id'])) {
                           $productId = $body['product_id'];
                        } else {
                           $productId = '';
                        }
                        if(!empty($listAllUsers)):
                           foreach($listAllUsers as $user):
                     ?>
                     <option value="<?php echo $user['id'] ?>"
                        <?php echo (!empty($userId) && $user['id'] == $userId) ? 'selected' : false ?>>
                        <?php echo $user['fullname'].'('.$user['phone'].')' ?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
               <div class="form-group">
                  <select name="factory_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Cơ sở gia công" data-width="100%">
                     <option value="0">Chọn tất cả</option>
                     <?php 
                        $body = getBody('get');
                        if(!empty($body['user_id'])) {
                           $userId = $body['user_id'];
                        } else {
                           $userId = '';
                        }
                        if(!empty($body['cate_id'])) {
                           $cateId = $body['cate_id'];
                        } else {
                           $cateId = '';
                        }
                        if(!empty($body['product_id'])) {
                           $productId = $body['product_id'];
                        } else {
                           $productId = '';
                        }
                        if(!empty($listAllFactories)):
                           foreach($listAllFactories as $factory):
                     ?>
                     <option value="<?php echo $factory['id'] ?>"
                        <?php echo (!empty($factoryId) && $factory['id'] == $factoryId) ? 'selected' : false ?>>
                        <?php echo $factory['name']?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
               <div class="form-group">
                  <select name="product_id" class="form-control selectpicker" data-live-search="true"
                     data-title="Sản phẩm" data-width="100%">
                     <option value="0">Chọn tất cả</option>
                     <?php 
                        $body = getBody('get');
                        if(!empty($body['user_id'])) {
                           $userId = $body['user_id'];
                        } else {
                           $userId = '';
                        }
                        if(!empty($body['factory_id'])) {
                           $factoryId = $body['factory_id'];
                        } else {
                           $factoryId = '';
                        }
                        if(!empty($body['cate_id'])) {
                           $cateId = $body['cate_id'];
                        } else {
                           $cateId = '';
                        }
                        if(!empty($listAllProducts)):
                           foreach($listAllProducts as $product):
                     ?>
                     <option value="<?php echo $product['id'] ?>"
                        <?php echo (!empty($productId) && $product['id'] == $productId) ? 'selected' : false ?>>
                        <?php echo $product['name'] ?>
                     </option>
                     <?php 
                           endforeach;
                        endif;
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
               <div class="form-group">
                  <select name="conclusion" id="conclusion" class="form-control">
                     <option value="0">Chọn kết luận</option>
                     <option value="1" <?php echo (!empty($conclusion) && $conclusion == 1) ? 'selected' : false ?>>
                        Chưa đạt
                     </option>
                     <option value="2" <?php echo (!empty($conclusion) && $conclusion == 2) ? 'selected' : false ?>>
                        Đạt
                     </option>
                     <option value="3" <?php echo (!empty($conclusion) && $conclusion == 3) ? 'selected' : false ?>>
                        Chờ xử lý
                     </option>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
               <div class="form-group">
                  <select name="status" id="status" class="form-control">
                     <option value="0">Chọn trạng thái ký</option>
                     <option value="1" <?php echo (!empty($statusSign) && $statusSign == 1) ? 'selected' : false ?>>
                        Đã ký
                     </option>
                     <option value="2" <?php echo (!empty($statusSign) && $statusSign == 2) ? 'selected' : false ?>>
                        Chưa ký
                     </option>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
               <div class="form-group">
                  <select name="choose" id="choose" class="form-control">
                     <?php 
                        if(!empty($listChooses)):
                           foreach($listChooses as $key=>$value): 
                     ?>
                     <option value="<?php echo $key ?>"
                        <?php echo (!empty($choose) && $choose == $key) ? 'selected' : false ?>>
                        <?php echo $value ?>
                     </option>
                     <?php endforeach; endif; ?>
                  </select>
               </div>
            </div>
            <div class="col-8">
               <input type="text" class="form-control" name="keyword" placeholder="Nhập từ khóa tìm kiếm..."
                  value="<?php echo !empty($keyword) ? $keyword : false ?>">
            </div>
            <div class="col-4">
               <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
         </div>
      </form>
      <table class="table table-bordered table-responsive">
         <thead>
            <tr>
               <th width="5%">STT</th>
               <th width="15%">Người tạo</th>
               <th width="15%">Cơ sở</th>
               <th width="17%">Mã biên bản</th>
               <th width="10%">Kết luận</th>
               <th width="10%">Ngày tạo</th>
               <th width="12%">Trạng thái</th>
               <?php if($isSeen): ?>
               <th width="5%">Xem</th>
               <?php endif; if($isEdit): ?>
               <th width="5%">Sửa</th>
               <?php endif; if($isDelete): ?>
               <th width="5%">Xóa</th>
               <?php endif; if($isExport): ?>
               <th width="5%">Xuất</th>
               <?php endif;?>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($listReportOnPage)):
                  $count = 0;
                  for($i = $offset; $i < ($offset + $reportOnPage); $i++):
                     $count++;
                     $isEditDelete = true;
                     if($user_id != $listReportOnPage[$i]["user_id"] && empty($isRoot)) {
                        $isEditDelete = false;
                     }
            ?>
            <tr>
               <td><?php echo $count ?></td>
               <td>
                  <a
                     href="<?php echo getLinkAdmin('reports', "", ['user_id'=>$listReportOnPage[$i]['user_id']])?>"><?php echo $listReportOnPage[$i]['name_user']  ?></a>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('reports', "", ['factory_id'=>$listReportOnPage[$i]['factory_id']])?>"><?php echo $listReportOnPage[$i]['name_factory']  ?></a>
               </td>
               <td>
                  <?php echo $listReportOnPage[$i]['code_report'];

                  if(empty($listReportOnPage[$i]['status_text'])) {
                     echo '';
                  } else {
                     if(empty($listReportOnPage[$i]['status_text']['status'])) {
                        echo $listReportOnPage[$i]['status_text'];
                     } else {
                        echo '<a class="ml-2 btn btn-danger" href="'.getLinkAdmin('reports', 'quick_sign', ["id" => $listReportOnPage[$i]['id']]).'?page='.$page.'">Ký ngay</a>';
                     }
                  }
                  ?>
               </td>
               <td><a
                     href="<?php echo getLinkAdmin('reports', "", ['conclusion'=>$listReportOnPage[$i]['conclusion']])?>">
                     <?php
                        if($listReportOnPage[$i]['conclusion']  == 1 ) {
                           echo 'Chưa đạt';
                        } 
                        if($listReportOnPage[$i]['conclusion']  == 2 ) {
                           echo 'Đạt';
                        } 
                        if($listReportOnPage[$i]['conclusion']  == 3 ) {
                           echo 'Chờ xử lý';
                        } 
                        
                     ?>
                  </a>
               </td>
               <td><?php echo getDateFormat($listReportOnPage[$i]["create_at"], 'd/m/Y H:i:s') ?></td>
               <td>
                  <?php 
                     $valueStatus = null;
                     $colorStatus = null;
                     foreach($statusReportArr as $key => $value) {
                        if($key == $listReportOnPage[$i]['status']) {
                           $valueStatus = $value['value'];
                           $colorStatus = $value['color'];
                        }
                     }
                  ?>
                  <lable class="btn btn-<?php echo $colorStatus?>"><?php echo $valueStatus ?></lable>
               </td>
               <?php if($isSeen): ?>
               <td class="text-center">
                  <a class="btn btn-success"
                     href="<?php echo getLinkAdmin('reports', 'seen', ['id' => $listReportOnPage[$i]['id']]) ?>">
                     <i class="far fa-eye"></i>
                  </a>
               </td>
               <?php endif; if($isEdit): ?>
               <td class="text-center">
                  <a class="btn btn-warning <?php echo $isEditDelete ? "" : "disabled" ?>"
                     href="<?php echo getLinkAdmin('reports', 'edit', ['id' => $listReportOnPage[$i]['id']]) ?>">
                     <i class="far fa-edit"></i>
                  </a>
               </td>
               <?php endif; if($isDelete): ?>
               <td class="text-center">
                  <a class="btn btn-danger <?php echo $isEditDelete ? "" : "disabled" ?>"
                     onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                     href="<?php echo getLinkAdmin('reports', 'delete', ['id' => $listReportOnPage[$i]['id']]) ?>">
                     <i class="fa fa-trash"></i>
                  </a>
               </td>
               <?php endif; if($isExport): ?>
               <td class="text-center">
                  <a class="btn btn-primary export" target="_blank"
                     href="<?php echo getLinkAdmin('reports', 'export', ['id' => $listReportOnPage[$i]['id']]) ?>">
                     <i class="fa fa-file-export"></i>
                  </a>
               </td>
               <?php endif;?>
            </tr>
            <?php
                  if($i == count($listReportOnPage) - 1) {
                     break;
                  }
                  endfor;
               else:
            ?>
            <tr>
               <td colspan="12" class="text-center alert alert-danger">Không có biên bản</td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <nav aria-label="Page navigation users"
         class="<?php echo ($numPage == 1 || empty($numPage)) ? 'd-none' : false ?>">
         <ul class="pagination pagination-sm justify-content-end <?php echo ($numPage == 1) ? 'd-none' : false ?>">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
               <a class="page-link" href="
            <?php     
               if($page <= 1) {
                  $prevPage = 1;
               } else {
                  $prevPage = $page - 1;
               }
               echo getLinkAdmin('reports').$queryStr.'page='.$prevPage;
            ?>">
                  Trước
               </a>
            </li>

            <?php 
         if(!empty($numPage)) {
            // Tính toán số phân trang bắt đầu để giới hạn trong limit page
            $begin = $page - 2;
            if($begin < 1) {
               $begin = 1;
            }
            $end = $begin + $limitPagination - 1;
            if($end >= $numPage) {
               $end = $numPage;
               $begin = $end - $limitPagination + 1;
            }

            if($numPage <= $limitPagination) {
               for($i = 1; $i <= $numPage; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('reports').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('reports').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  }
               }
            } else {
               for($i = $begin; $i <= $end; $i++) {
                  if($page == $i) {
                     echo '<li class="page-item active"><a class="page-link" href="'.getLinkAdmin('reports').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  } else {
                     echo '<li class="page-item"><a class="page-link" href="'.getLinkAdmin('reports').$queryStr.'page='.$i.'">'.$i.'</a></li>';
                  }
               }
            }
         }   
      ?>

            <li class="page-item">
               <a class="page-link" href="
         <?php 
            if($page >= $numPage) {
               $nextPage = 1;
            } else {
               $nextPage = $page + 1;
            }
            echo getLinkAdmin('reports').$queryStr.'page='.$nextPage;
         ?>">
                  Sau
               </a>
            </li>
            <li class="page-item">
               <a class="page-link <?php echo ($page == $numPage) ? 'disabled' : '' ?>" href="
         <?php 
               echo getLinkAdmin('reports').$queryStr.'page='.$numPage;
            ?>">
                  Trang cuối
               </a>
            </li>
         </ul>
      </nav>
   </div><!-- /.container-fluid -->
</section>
<?php
   layout('footer', 'admin', $data);
?>
<?php
if(!defined('_INCODE')) die('Access denied...');
/**
 * Các hàm xử lý chung
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Hàm để reqired các layout
 function layout($layoutName = 'header',$dir='', $data = []) {
  if(!empty($dir)) {
    $dir = '/'.$dir;
  }
   if(file_exists(_WEB_PATH_TEMPLATE.$dir.'/layouts/'.$layoutName.'.php')) {
      require_once _WEB_PATH_TEMPLATE.$dir.'/layouts/'.$layoutName.'.php';
   }
 }

 // Hàm dùng để gửi mail tự động (quên mật khẩu, kích hoạt tài khoản)
function sendMail($to, $subject, $content) {
  //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tamtt1512@gmail.com';                     //SMTP username
    $mail->Password   = 'kctt nfxn qipj mnry';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('tamtt1512@gmail.com', 'Tôn Thành Tâm');
    $mail->addAddress($to);     //Add a recipient
    // $mail->addReplyTo($to, $content_mail); // Xác định email sẽ được thêm vào phần trả lời

    //Content
    $mail->isHTML(true);     
    $mail->CharSet = 'utf8';                             //Set email format to HTML
    $mail->Subject = $subject; // Tiêu đề email
    $mail->Body    = $content; // Nội dung email

    return $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

// Kiểm tra phương thức Post
function isPost() {
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    return true;
  }

  return false;
}

// Kiểm tra phương thức Get
function isGet() {
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    return true;
  }
  return false;
}

// Lấy giá trị phương thức POST, GET
function getBody($method="") {
  $bodyArr = [];
  $method = strtolower($method);
  if(empty($method)) {
    if(isGet()) {
      if(!empty($_GET)) {
        foreach ($_GET as $key => $value) {
          if(is_array($value)) { // kiểm tra xem $value có phải mảng không
            $bodyArr[strip_tags($key)] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            // $bodyArr[strip_tags($key)] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // cho phép dữ liệu là mảng / strip_tags(giúp loại bỏ các thẻ html khỏi chuỗi, ở đây ta không tiến hành $key=strip_tags($key) vì làm vậy sẽ làm thay đổi giá trị của $key -> không lấy được giá trị của $key ban đầu từ $_GET, ta có thẻ chủ động hơn bằng việc chỉ đổi $key của $bodyArr vì đây là chuỗi mà ta sẽ lấy ra để sử dụng, nên cứ custom theo ý ta muốn/ mặc định thì các $key và value của $_GET sẽ loại bỏ các thẻ html)
          } else {
            $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
            // $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // lọc các giá trị đặc biệt của $_GET[$key] và mã hóa chúng (hiển thị trong $_GET thì vẫn đúng với nội dung trên url, nhưng trong source thì được mã hóa (vd: \n, các thẻ html nếu không dùng hàm này thì sẽ bị làm đúng chức năng của nó làm cho ta không lấy được giá trị mong muốn)), đảm bảo dữ liệu sạch và an toàn (tránh được các mã script và các ký tự đặc biệt) nhược điểm của nó là lọc luôn cả kiểu dữ liệu chuỗi (điều nàu sẽ được giải quyết ở phía trên)
          }
  
        }
      }
    }
    if(isPost()) {
      if(!empty($_POST)) {
        foreach ($_POST as $key => $value) {
          if(is_array($value)) { 
            $bodyArr[strip_tags($key)] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); 
          } else {
            $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS); 
          }
  
        }
      }
    }
  } else {
    if($method == 'get') {
      if(!empty($_GET)) {
        foreach ($_GET as $key => $value) {
          if(is_array($value)) { // kiểm tra xem $value có phải mảng không
            $bodyArr[strip_tags($key)] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            // $bodyArr[strip_tags($key)] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // cho phép dữ liệu là mảng / strip_tags(giúp loại bỏ các thẻ html khỏi chuỗi, ở đây ta không tiến hành $key=strip_tags($key) vì làm vậy sẽ làm thay đổi giá trị của $key -> không lấy được giá trị của $key ban đầu từ $_GET, ta có thẻ chủ động hơn bằng việc chỉ đổi $key của $bodyArr vì đây là chuỗi mà ta sẽ lấy ra để sử dụng, nên cứ custom theo ý ta muốn/ mặc định thì các $key và value của $_GET sẽ loại bỏ các thẻ html)
          } else {
            $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
            // $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // lọc các giá trị đặc biệt của $_GET[$key] và mã hóa chúng (hiển thị trong $_GET thì vẫn đúng với nội dung trên url, nhưng trong source thì được mã hóa (vd: \n, các thẻ html nếu không dùng hàm này thì sẽ bị làm đúng chức năng của nó làm cho ta không lấy được giá trị mong muốn)), đảm bảo dữ liệu sạch và an toàn (tránh được các mã script và các ký tự đặc biệt) nhược điểm của nó là lọc luôn cả kiểu dữ liệu chuỗi (điều nàu sẽ được giải quyết ở phía trên)
          }
  
        }
      }
    } else if($method == 'post') {
      if(!empty($_POST)) {
        foreach ($_POST as $key => $value) {
          if(is_array($value)) { 
            $bodyArr[strip_tags($key)] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); 
          } else {
            $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS); 
          }
  
        }
      }
    }
  }
  return $bodyArr;
}

// kiểm tra email
function isEmail($email) {
  $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
  return $checkEmail; // đúng trả về giá trị email, sai trả về false
}

// Kiểm tra số nguyên 
function isNumberInt($number, $range = []) {
/**
 * $range = [
  * 'min_range' => 1,
  * 'max_range' => 10
 * ]
 */
  $checkNumber = null;
  if(!empty($range)) {
    $option = ['options' => $range];
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $option);
  } else {
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
  }

  return $checkNumber;
}
// Kiểm tra số thực
function isNumberFloat($number, $range = []) {
  $checkNumber = null;
  if(!empty($range)) {
    $option = ['options' => $range];
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $option);
  } else {
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
  }

  return $checkNumber;
}

//Kiểm tra số điện thoại, bắt đầu bằng số không, 10 chữ số
function isPhone($phone) {
  $checkZeroFirst = false;
  if($phone[0] == '0') {
    $checkZeroFirst = true;
    $phone = substr($phone, 1);
  }

  $checkNumberLast = false;
  
  if(isNumberInt($phone) && strlen($phone) == 9) {
    $checkNumberLast = true;
  }

  if($checkZeroFirst && $checkNumberLast) {
    return true;
  }

  return false;
}

//Hàm lấy thông báo
function getMsg($message, $type = 'success') {
  if(!empty($message)) {
    echo '<div class="text-center alert alert-'.$type.'">';
    echo $message;
    echo '</div>';
  }
}

function form_error($fieldName, $errors, $beforeHtml = '', $afterHtml = '') {
  if(!empty($errors[$fieldName])) {
   return $beforeHtml . reset($errors[$fieldName]) . $afterHtml;
  }
}
function form_infor($fieldName, $infor) {
  if(!empty($infor[$fieldName])) {
   return $infor[$fieldName];
  }
}

function old($fieldName, $oldData, $default = null) {
    if(!empty($oldData[$fieldName])) {
      return $oldData[$fieldName];
     } else {
      return $default;
     }
}

function redirect($path = 'index.php') {
  $url = _WEB_HOST_ROOT.'/'.$path;
  header("location: $url");
  exit;
}

function isLogin() {
  if(!empty(getSession('login_token'))) {
    $loginToken = getSession('login_token');
    $queryLoginToken = firstRaw("SELECT id, user_id FROM login_token WHERE token = '$loginToken'");
    if(!empty($queryLoginToken)) {
      return $queryLoginToken;
    } else {
      removeSession('login_token');
    }
  } 
  return false;
}


//Lưu lại thời gian cuối cùng hoạt động
function saveActivity() {
  $user_id = isLogin()['user_id'];
  update('users', ['last_activity' => date('Y-m-d H:i:s')], 'id='.$user_id);
  setcookie('user_id', $user_id, time() + 60*_TIME_OUT_LOGIN, '/');
}

//Tự động xóa token khi người dùng không hoạt động _TIME_OUT_LOGIN phút hoặc thoát trình duyệt quá thời gian đó, nếu trong thời gian đó người dùng quay lại trang web thì sẽ tự động đăng nhập
function autoLogin() {
  if(!empty($_COOKIE['user_id'])) {
    $cookie_user = $_COOKIE['user_id'];
      $queryLoginToken = firstRaw("SELECT * FROM login_token WHERE user_id = '$cookie_user'");
      if(!empty($queryLoginToken)) {
          setSession('login_token', $queryLoginToken['token']);
      }
  }
}

//Tự động xóa login_token sau một khoản thời gian không hoạt động
function autoRemoveLoginToken() {
  $user_id = isLogin()['user_id'];
  $queryUser = firstRaw("SELECT last_activity FROM users WHERE id = $user_id");
  $last_activity = $queryUser['last_activity'];
  $now = date('Y-m-d H:i:s');
  $diff = strtotime($now) - strtotime($last_activity);
  $diff = floor($diff/60);
  if($diff >= _TIME_OUT_LOGIN) {
    delete('login_token', "user_id=$user_id");
    setcookie('user_id', $user_id, time()-60, '/');
    return true;
  }
  return false;
}

//Action menu sidebar (active and menu-open) 
/**
 * kiểu tra với đường dẫn phương thức GET
 * 1. module đúng sẽ active child đầu tiên
 * 2. module và action đúng sẽ active child của action đó
 * 3. nếu không có module sẽ active mặc định
 * 4. nếu child có sub, truyền vào tham số sub là mảng, các action = với một trong các tham số sẽ được tính là đúng
 * 5. nếu một module nằm trong 1 module khác sử dụng biến $moduleSub để kích hoạt
 */
function activeMenuSidebar($module, $action='', $sub = false, $moduleSub = '') { //service add
  if(empty(getBody()['module']) && empty($module)) {
    return true;
  } else {
    if(!empty(getBody()['action'])) {
      if(!empty($module)) {
        if(getBody()['module'] == $module && getBody()["action"] == $action) {
          return true;
        }
        if(getBody()['module'] == $module && $sub && !is_array($sub)) {
          return true;
        }
        if(!empty($sub) && is_array($sub)) {
          foreach($sub as $item) {
            //strpos(getBody()['module'], $module) !== false
            if(getBody()['module'] == $module && getBody()["action"] == $item) {
              return true;
            }
          }
        }
      }
    } else {
      if(!empty(getBody()['module']) && !empty($module)) {
        if(getBody()['module'] == $module && empty($action)) {
          return true;
        }
      }
      if(!empty(getBody()["module"])) {
        // echo getBody()["module"];
        if(getBody()['module'] == $moduleSub) {
          return true;
        }
      }
    }
  }
  
  return false;
}

//Get link admin
function getLinkAdmin($module, $action = "", $params = []) {
  $moduleArr = [
    'dashboard' => '',
    'auth' => '',
    'defect_categories' => 'danh-muc-loi',
    'defects' => 'loi',
    'product_categories' => 'danh-muc-san-pham',
    'products' => 'san-pham',
    'report_categories' => 'danh-muc-bien-ban',
    'reports' => 'bien-ban',
    'groups' => 'nhom-nguoi-dung',
    'users' => 'nguoi-dung',
    'factories' => 'co-so',
    'statistical_reports' => 'thong-ke'
  ];

  $actionArr = [
    'add' => 'them',
    'edit' => 'chinh-sua',
    'delete' => 'xoa',
    'seen' => 'xem',
    'seen_images_report_defect' => 'xem-anh-loi',
    'report_defect_delete' => 'xoa-loi-bien-ban',
    'export' => 'xuat-pdf',
    'export_excel' => 'xuat-excel',
    'notifications' => 'thong-bao',
    'permission' => 'phan-quyen',
    'sign' => 'chu-ky-ca-nhan',
    'profile' => 'thong-tin-ca-nhan',
    'edit_pass' => 'doi-mat-khau',
    'login' => 'dang-nhap',
    'logout' => 'dang-xuat',
    'defect_detail' => 'chi-tiet',
    'quick_sign' => 'ky-nhanh',
    'confirm_report' => 'xac-nhan-bien-ban',
    'seen_images_defect' => 'xem-anh-loi-bien-ban'
  ];

  $url = _WEB_HOST_ROOT_ADMIN;
  if(!empty($moduleArr[$module])) {
    $url .= "/".$moduleArr[$module];
  }

  if(!empty($actionArr[$action])) {
    $url.= "/".$actionArr[$action];
  }

  /**
   * $params = ['id' => 1, 'keyword' => 'unicode']
   * => paramString = id=1&keyword=unicode
   */
  if(!empty($params)) {
    foreach($params as $key => $value) {
      $url.="/$key=$value";

    }
    // $paramString = http_build_query($params);
  }
  return $url;
}

//Format date
function getDateFormat($dateStr, $format) {
  $dateObject = date_create($dateStr);
  if(!empty($dateObject)) {
    return date_format($dateObject, $format);
  }
  return false;
}

//Check icon
function isIcon($input) {
  if(strpos($input, '<i class="') != false) {
    return true;
  }
  return false;
}

function getNameUserUniqueOrId($listUser, $input) {
  if(!empty($listUser)) {
    foreach($listUser as $user) {
      if(!empty($input)) {
        if(isNumberInt($input)) {
          if($user['id'] == $input) {
            $fullname = $user['fullname'];
            $email = $user['email'];
            return $fullname."($email)";
          }
        } else if(is_string($input)) {
          $input = rtrim($input, ")");
          $inputArray = explode('(', $input);
          $fullname = $inputArray[0];
          $email = $inputArray[1];
          if($user['fullname'] == $fullname && $user['email'] == $email) {
            return $user['id'];
          }
        }
      }
    }
  }
  return false;
}

function getLevelString($level) {
  $levelData = json_decode($level);
  if($levelData === null) {
    return $level;
  } else {
    $unit = $levelData->unit;
    $conditions = $levelData->conditions;
    $resultString = '';
    foreach($conditions as $item) {
      $name = $item->name;
      $condition = $item->condition;
      $value = $item->value;

      if($condition == '<=') {
        $condition = '≤';
      }

      $resultString .= "$name $condition $value $unit <br>";
    }
    return $resultString;
  }
}

function getLevelReportDefect($defect_quantity, $defectId) {
  if(!empty($defectId)) { 
    $level = firstRaw("SELECT level FROM defects WHERE id = $defectId")['level'];
    if(!empty($level)) {
      $levelData = json_decode($level);
      if($levelData === null) {
        return $level;
      } else {
        $conditions = $levelData->conditions;
        foreach($conditions as $item) {
          $name = $item->name;
          $condition = $item->condition;
          $value = $item->value;

          if($condition == "<=") {
            if($defect_quantity <= $value) {
              return $name;
            }
          }
          if($condition == ">") {
            if($defect_quantity > $value) {
              return $name;
            }
          }
        }
      }
    }
  }
  return false;
}
function getIdCategoryDefect($name, $listCate) {
  foreach($listCate as $cate) {
    if($cate['name'] == $name) {
      return $cate['id'];
    }
  }
  return false;
}

function getIdCateDefectByIdDefect($id, $listDefect) {
  foreach($listDefect as $defect) {
    if($defect['id'] == $id) {
      return $defect['cate_id'];
    }
  }
  return false;
}

function getNameDefectById($id, $listDefects) {
  foreach($listDefects as $defect) {
    if($defect['id'] == $id) {
      return $defect['name'];
    }
  }
  return false;
}

function getNameDefectCategoyById($id, $listDefectCates) {
  foreach($listDefectCates as $defectCate) {
    if($defectCate['id'] == $id) {
      return $defectCate['name'];
    }
  }
  return false;
}

function getMaxId($list) {
  $max = 0;
  foreach($list as $item) {
    if($item['id'] >= $max) {
      $max = $item['id'];
    }
  }
  return $max;
}
function uploadFile($config, $fieldName, $file = []) {
  $errors = [];
  
  // Trường hợp upload multi file
  if(!empty($file) && is_array($file)) {
     $_FILES[$fieldName] = $file;
  }

  if(!empty($config['upload_dir'])) {
     $upload_dir = $config['upload_dir'];
  } else {
     $errors[] = 'empty upload_dir';
  }

  if(!empty($config['allowed'])) {
     $allowArr = explode(',', $config['allowed']);
     foreach ($allowArr as $key=>$value) {
        $allowArr[$key] = trim($value);
     }
     $allowArr = array_filter($allowArr);
  } else {
     $errors[] = 'empty allowed';
  }

  if(!empty($config['max_size'])) {
     $max_size = $config['max_size'];
  } else {
     // $errors[] = 'empty max_size'; 
  }

  if(!empty($config['change_file_name'])) {
     $change_file_name = $config['change_file_name'];
  } else {
     // $errors[] = 'empty change_file_name';
  }

  if(!empty($_FILES[$fieldName])) {
     $file_upload = $_FILES[$fieldName];
     $file_name = $file_upload['name'];
     $file_size = $file_upload['size'];
     $path_file_tmp = $file_upload['tmp_name'];
     $error = $file_upload['error'];

     $file_name_arr = explode('.', trim($file_name));
     $file_ext = end($file_name_arr);
     $file_before = str_replace('.'.$file_ext, '', $file_name);

     if(!empty($change_file_name)) {
        $file_name = $file_before.'_'.$change_file_name.'.'.$file_ext;
     }

     if($error == 4) {
        $errors[] = 'choose_file';
     } else {
        if(!empty($allowArr) && is_array($allowArr) && !in_array($file_ext, $allowArr)) {
           $errors[] = 'allow_ext';
        }

        if(!empty($file_size)) {
           if(!empty($max_size) && $file_size > $max_size) {
              $errors[] = 'max_size';
           } 
        } else {
           $errors[] = 'file_error';
        }
     }

     if(empty($errors)) {
        if(!empty($upload_dir)) {
           $upload = move_uploaded_file($path_file_tmp, _WEB_PATH_ROOT_ADMIN.$upload_dir.'/'.$file_name);

           if($upload) {
              return [
                 'status' => 'success',
                 'fileOr' => $_FILES[$fieldName]['name'], //file origin
                 'file_name' => $file_name,
                 'size' => $file_size,
                 'path' => _WEB_PATH_ROOT_ADMIN.$upload_dir.'/'.$file_name,
                 'link' => _WEB_HOST_ROOT_ADMIN.$upload_dir.'/'.$file_name
              ];
           } else {
              return false;
           }
        }
     } else {
        $errors['status'] = 'false';
     }
  }
  return $errors;
}
function fileMulti($fieldName) {
  $fileArr = [];
  if(!empty($_FILES[$fieldName])) {
     foreach($_FILES[$fieldName]['name']  as $key=>$value) {
        $fileArr[] = [
           'name' => $value,
           'type' => $_FILES[$fieldName]['type'][$key],
           'tmp_name' => $_FILES[$fieldName]['tmp_name'][$key],
           'error' => $_FILES[$fieldName]['error'][$key],
           'size' => $_FILES[$fieldName]['size'][$key],
        ];
  }
  }
  return $fileArr;
}

function AQL($quantityDeliver) {
  $simpleSize = "";
  $majorDefects = "";
  $minorDefects = "";

  if ($quantityDeliver >= 2 && $quantityDeliver <= 8) {
    $simpleSize = 2;
    $majorDefects = 0;
    $minorDefects = 0;
  } else if ($quantityDeliver > 8 && $quantityDeliver <= 15) {
    $simpleSize = 3;
    $majorDefects = 0;
    $minorDefects = 0;
  } else if ($quantityDeliver > 15 && $quantityDeliver <= 25) {
    $simpleSize = 5;
    $majorDefects = 0;
    $minorDefects = 1;
  } else if ($quantityDeliver > 25 && $quantityDeliver <= 50) {
    $simpleSize = 8;
    $majorDefects = 1;
    $minorDefects = 1;
  } else if ($quantityDeliver > 50 && $quantityDeliver <= 90) {
    $simpleSize = 13;
    $majorDefects = 1;
    $minorDefects = 1;
  } else if ($quantityDeliver > 90 && $quantityDeliver <= 150) {
    $simpleSize = 20;
    $majorDefects = 1;
    $minorDefects = 2;
  } else if ($quantityDeliver > 150 && $quantityDeliver <= 280) {
    $simpleSize = 32;
    $majorDefects = 2;
    $minorDefects = 3;
  } else if ($quantityDeliver > 280 && $quantityDeliver <= 500) {
    $simpleSize = 50;
    $majorDefects = 5;
    $minorDefects = 3;
  } else if ($quantityDeliver > 500 && $quantityDeliver <= 1200) {
    $simpleSize = 80;
    $majorDefects = 5;
    $minorDefects = 7;
  } else if ($quantityDeliver > 1200 && $quantityDeliver <= 3200) {
    $simpleSize = 125;
    $majorDefects = 7;
    $minorDefects = 10;
  } else if ($quantityDeliver > 3200 && $quantityDeliver <= 10000) {
    $simpleSize = 200;
    $majorDefects = 10;
    $minorDefects = 14;
  } else if ($quantityDeliver > 10000 && $quantityDeliver <= 35000) {
    $simpleSize = 315;
    $majorDefects = 14;
    $minorDefects = 21;
  } else if ($quantityDeliver > 35000 && $quantityDeliver <= 150000) {
    $simpleSize = 500;
    $majorDefects = 21;
    $minorDefects = 21;
  } else if ($quantityDeliver > 150000 && $quantityDeliver <= 500000) {
    $simpleSize = 800;
    $majorDefects = 21;
    $minorDefects = 21;
  } else if ($quantityDeliver > 500000) {
    $simpleSize = 1250;
    $majorDefects = 21;
    $minorDefects = 21;
  }

  return [
    "simpleSize" => $simpleSize,
    "criticalDefects"=> 0,
    "majorDefects" => $majorDefects,
    "minorDefects" => $minorDefects,
  ];
}

function getSumDefectByType($listAllReportDefect) {
  $sumCriticalDefects = 0;
  $sumMajorDefects = 0;
  $sumMinorDefects = 0;
  if(!empty($listAllReportDefect)) {
    foreach($listAllReportDefect as $item) {
      if($item['skip'] == 0) {
        $level = $item["level"];
        if($level == "Nghiêm trọng") {
          $sumCriticalDefects += $item["defect_quantity"];
        } else if($level == "Nặng") {
          $sumMajorDefects += $item["defect_quantity"];
        } else if($level == "Nhẹ") {
          $sumMinorDefects += $item["defect_quantity"];
        }
      }
    }
  }
  return [
    'sumCriticalDefects' => $sumCriticalDefects,
    'sumMajorDefects' => $sumMajorDefects,
    'sumMinorDefects' => $sumMinorDefects
  ];
}

function checkResultAQL($quantityDeliver, $criticalDefectsReal, $majorDefectsReal, $minorDefectsReal) {
  $quantityDefect = AQL($quantityDeliver);
  $criticalDefects = $quantityDefect["criticalDefects"];
  $majorDefects = $quantityDefect["majorDefects"];
  $minorDefects = $quantityDefect["minorDefects"];

  if ($criticalDefectsReal == $criticalDefects && $majorDefectsReal <= $majorDefects && $minorDefectsReal <= $minorDefects) {
    return 2; //ĐẠT
  } else {
    return 1; //KHÔNG ĐẠT
  }
}

// Xóa session khác report đang thêm và chỉnh sửa
function deleteSessionOutReport() {
  $module = null;
  $action = null;
  $id = null;
  $url = trim($_SERVER["QUERY_STRING"]);
  $urlArr = explode("&", $url);
  foreach($urlArr as $item) {
    $itemArr = explode("=", $item);
    if($itemArr[0] == 'module') {
      $module = $itemArr[1];
    }
    if($itemArr[0] == 'action') {
      $action = $itemArr[1];
    }
    if($itemArr[0] == 'id') {
      $id = $itemArr[1];
    }
  }
  // # module reports xóa tất cả session
  if(!empty($module)) {
    if($module != 'reports') {
      removeSession('listAllReportDefectsAdd');
      // xóa ds các listAllReportDefects
      deleteAllSession('listAllReportDefects');
    } else {
      if(!empty($action)) {
        // action # add và edit xóa hết
        if($action != 'add' && $action != 'edit') {
          removeSession('listAllReportDefectsAdd');
          // xóa ds các listAllReportDefects
          deleteAllSession('listAllReportDefects');
        }
        // # action add xóa list add
        if($action != 'add') {
          removeSession('listAllReportDefectsAdd');
        }
        if($action != 'edit') {
          // Xóa toàn bộ list edit
          deleteAllSession('listAllReportDefects');
        } else {
          // giử lại list edit trùng id, xóa tất cả list edit khác id
          deleteAllSession('listAllReportDefects', $id);
        }
      } else {
        removeSession('listAllReportDefectsAdd');
        // xóa ds các listAllReportDefects
        deleteAllSession('listAllReportDefects');
      }
    }
  }
}

function deleteAllSession($keySession, $id = null) {
  if(!empty($keySession)) {
    if(!empty($_SESSION)) {
      if(!empty($id)) {
        foreach($_SESSION as $key => $value) {
          if(strpos($key, $keySession) !== false && $key != "listAllReportDefectsAdd") {
            if($keySession."[$id]" != $key) {
              removeSession($key);
            }
          }
        }
      } else {
        foreach($_SESSION as $key => $value) {
          if(strpos($key, $keySession) !== false && $key != "listAllReportDefectsAdd") {
            removeSession($key);
          }
        }
      }
      return true;
    }
  }
  return false;
}


function checkPermission($data, $module, $action) {
  if(!empty($data[$module]) && in_array($action, $data[$module])) {
    return true;
  }
  return false;
}

function getGroupId() {
  $userId = isLogin()['user_id'];
  $user = firstRaw("SELECT group_id FROM users WHERE id = $userId");
  if(!empty($user)) {
    return $user['group_id'];
  }
  return false;
}

function getPermissionData($groupId) {
  $group = firstRaw("SELECT permission FROM groups WHERE id = $groupId");
  if(!empty($group)) {
    return json_decode($group['permission'], true);
  }
  return false;
}

function getScore($percentSerious, $percentHeavy, $percentLight) {
  $serious = $percentSerious * 60 / 100;
  $heavy = $percentHeavy * 30 / 100;
  $light = $percentLight * 10 / 100;

  $total = $serious + $heavy + $light;

  if($total < 10) {
    return $total."%/100";
  } else if($total >= 10 && $total <= 20) {
    return $total."%/90";
  } else if($total > 20 && $total <= 30) {
    return $total."%/80";
  } else if($total > 30 && $total <= 40) {
    return $total."%/70";
  } else if($total > 40) {
    return $total."%/60";
  }

  return false;
}

function showName($fullName) {
  $fullNameArr = explode(' ', $fullName);
  $countFullName = count($fullNameArr);
  if($countFullName >= 2) {
    return $fullNameArr[$countFullName - 2]." ".$fullNameArr[$countFullName - 1]; 
  } else {
    return $fullName;
  }
}

//set_exception_handler
function setExceptionError($e) {
  if(empty(getSession('debug_error'))) {
    setSession('debug_error', [
      "error_code" => $e->getCode(),
      "error_message" => $e->getMessage(),
      "error_file" => $e->getFile(),
      "error_line" => $e->getLine()
    ]);
  }

  $isReload = getSession('reload');
  if(empty($isReload)) {
    setSession('reload', 1);
    redirect(getPathAdmin());
  } else {
    removeSession('reload');
    removeSession('debug_error');
  }
}

// Tạo ra session và exception để hiển thị một cách độc lập (do mặc định là lỗi ở đâu thì sẽ hiển thị ở đó, khó kiểm soát không chuyên nghiệp)
function setErrorHandler($errno, $errstr, $errfile, $errline) {
  // tạo exception để set_exception_handler bắt được và hiển thị ra
  if(!_DEBUG) {
    return;
  }

  setSession('debug_error', [
    "error_code" => $errno,
    "error_message" => $errstr,
    "error_file" => $errfile,
    "error_line" => $errline
  ]);
 throw new ErrorException($errstr, $errno, 1, $errfile, $errline);
}

function loadExceptionError() {
  if(!empty(getSession('debug_error'))) {
    if(_DEBUG) {
      $exception = getSession('debug_error');
      require_once _WEB_PATH_ROOT.'/modules/errors/exception.php';
    } else {
      require_once _WEB_PATH_ROOT.'/modules/errors/500.php';
    }
  } 
  removeSession('reload');
  removeSession('debug_error');
}

function getPathAdmin() {
  $path = "admin";
  if(!empty($_SERVER['PATH_INFO'])) {
      $path .= $_SERVER['PATH_INFO'];
  }
  if(!empty($_SERVER["QUERY_STRING"])) {
    $path.='?'.trim($_SERVER["QUERY_STRING"]);
  }
  return $path;
}

function checkId($module, $id) {
    $check = firstRaw("SELECT id FROM $module WHERE id=$id");
    if(!empty($check)) {
        return true;
    }
    return false;
}
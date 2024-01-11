<?php 
   if(isPost()) {
      $body = getBody("post");
      $px = $body['px'];
      $code = 1;
      $currentYear = date('Y');

      $listAllCodeReport = getRaw("SELECT code_report FROM reports WHERE YEAR(create_at) = $currentYear");

      if(!empty($listAllCodeReport)) {
         $listAllCode = [];
         foreach($listAllCodeReport as $codeRp) {
            $arrCode = explode("/", $codeRp["code_report"]);
            $listAllCode[] = intval($arrCode[0]);
         }
         $maxCode = max($listAllCode) + 1;

         $code = str_pad("$maxCode", 6, "0", STR_PAD_LEFT);
      }

      echo "$code/$px/$currentYear";
   }
?>
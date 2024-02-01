<?php 
    if(isPost()) {
        $body = getBody('post');
        $name = $body['name'];
        $value = $body['value'];
        echo "$name: $value";
        $infoAdd = [];
        if(!empty(getSession('infoAdd'))) {
            $infoAdd = getSession('infoAdd');
        }

        if(!empty($infoAdd)) {
            $isChange = false;
            foreach($infoAdd as $k => $v) {
                if($name == $k) {
                    $isChange = true;
                    $infoAdd[$name] = $value;
                    break;
                }
            }

            if(!$isChange) {
                $infoAdd[$name] = $value;
            }
        } else {
            $infoAdd= [
                $name => $value
            ]; 
        }

        
        setSession("infoAdd", $infoAdd);

        echo json_encode($infoAdd);
    }
?>
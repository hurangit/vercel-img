<?php
$agent = $_SERVER['HTTP_USER_AGENT'];
if(stripos($agent,'android')!==false || stripos($agent, 'iphone')!==false){
    if (file_exists('../peurl.csv')) {
		$url = file('../peurl.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	} else {
		$url = file('http://' . $_SERVER['HTTP_HOST'] . '/peurl.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
	if (empty($url[0])) {
		$code = 503;
		$target_url = ERROR_IMG[503];
	}
	
	$id         = $_REQUEST['id'];
    $type       = $_REQUEST['type'];
    $length    = count($url);
    $final_id   = array_rand($url);
    $is_idValid = false;
	
	if (isset($id)) {
        header('Cache-Control: public, max-age=86400');
        if (is_numeric($id)) {
            settype($id, 'integer');
            if ($is_idValid = is_int($id)) {
                $final_id = $id;  // id是整数
            }
        }
    } else {
        header('Cache-Control: no-cache');
    }
	if (!$code && $is_idValid && $final_id > $length) {
        // exceed maximum length
        $code       = 404;
        $target_url = ERROR_IMG[404];
    } else {
        $code       = 200;
        $target_url = $url[$final_id];
    }
	header('Access-Control-Max-Age: 86400'); //1day
    header('Access-Control-Allow-Origin: *');
	switch ($type) {
        case 'length':
            echo $length;
            break;
        case 'json':
            $result = [
                'code' => $code,
                'url' => $target_url
            ];
            header('Content-Type: text/json');
            echo json_encode($result);
            break;
        case 'JSON':
            $result           = [
                'code' => $code,
                'url' => $target_url
            ];
            $imageInfo        = getimagesize($target_url);
            $imageSize        = get_headers($target_url, 1)['Content-Length'];
            $result['width']  = $imageInfo[0];
            $result['height'] = $imageInfo[1];
            $result['mime']   = $imageInfo['mime'];
            $result['size']   = $imageSize;
            header('Content-Type: text/json');
            echo json_encode($result);
            break;
        case 'output':
            header($header);
            if (ALLOW_OUTPUT) {
                header('Content-Type: image/png');
                echo file_get_contents($target_url);
            } else {
                die('disabled');
            }
            break;
        default:
            header('Location: ' . $target_url);
	}
}else {
    if (file_exists('../pcurl.csv')) {
		$url = file('../pcurl.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	} else {
		$url = file('http://' . $_SERVER['HTTP_HOST'] . '/pcurl.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
	if (empty($url[0])) {
		$code = 503;
		$target_url = ERROR_IMG[503];
	}
	
	$id         = $_REQUEST['id'];
    $type       = $_REQUEST['type'];
    $length    = count($url);
    $final_id   = array_rand($url);
    $is_idValid = false;
	
	if (isset($id)) {
        header('Cache-Control: public, max-age=86400');
        if (is_numeric($id)) {
            settype($id, 'integer');
            if ($is_idValid = is_int($id)) {
                $final_id = $id;  // id是整数
            }
        }
    } else {
        header('Cache-Control: no-cache');
    }
	if (!$code && $is_idValid && $final_id > $length) {
        // exceed maximum length
        $code       = 404;
        $target_url = ERROR_IMG[404];
    } else {
        $code       = 200;
        $target_url = $url[$final_id];
    }
	header('Access-Control-Max-Age: 86400'); //1day
    header('Access-Control-Allow-Origin: *');
	switch ($type) {
        case 'length':
            echo $length;
            break;
        case 'json':
            $result = [
                'code' => $code,
                'url' => $target_url
            ];
            header('Content-Type: text/json');
            echo json_encode($result);
            break;
        case 'JSON':
            $result           = [
                'code' => $code,
                'url' => $target_url
            ];
            $imageInfo        = getimagesize($target_url);
            $imageSize        = get_headers($target_url, 1)['Content-Length'];
            $result['width']  = $imageInfo[0];
            $result['height'] = $imageInfo[1];
            $result['mime']   = $imageInfo['mime'];
            $result['size']   = $imageSize;
            header('Content-Type: text/json');
            echo json_encode($result);
            break;
        case 'output':
            header($header);
            if (ALLOW_OUTPUT) {
                header('Content-Type: image/png');
                echo file_get_contents($target_url);
            } else {
                die('disabled');
            }
            break;
        default:
            header('Location: ' . $target_url);
	}
}
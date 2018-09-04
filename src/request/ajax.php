<?php
namespace Ejax\_Request\Ajax;
require_once SRC_ROOT.'/auth/funcs/required.php';

    \Auth\requiredForSystem();
    
    header("Content-type: text/plain; charset=UTF-8");

//	AJAXによるアクセスかどうかを判別する
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'){
        http_response_code(403);
    //    die('This access is not valid.');
        exit;
    }

//	読み込む
	require __DIR__.'/../'.$__access_ajax_kind;
?>
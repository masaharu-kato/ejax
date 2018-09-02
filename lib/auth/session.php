<?php
namespace Auth;
	require_once __DIR__.'/token.php';
	require_once __DIR__.'/../request.php';

	//  ログインせずにログインの必要な画面に来た時にログイン画面へ飛ばす処理
	function require_logined_session($URL_LOGIN){

	    // セッション開始
	    @session_start();

		$_SESSION['original_uri'] = \Request\getFullURI();

	    if(!isset($_SESSION['username'])){
	        header('Location: '.$URL_LOGIN); // 移動先
	        exit;
	    }

	}

	//  ログイン済みの状態でログイン画面に来た時にトップページへ飛ばす処理
	function require_unlogined_session($URL_INDEX){

	    // セッション開始
	    @session_start();

	    if(isset($_SESSION['username'])){
	        header('Location: '.$URL_INDEX); // 移動先  
	        exit;
	    }
	    
	}

	function session_unset_cookie() {
		setcookie(session_name(), '', 1, null, SESSION_DOMAIN);
	}




	//  ログインせずにログインの必要な画面に来た時にエラー画面を表示する
	function require_auth_or_redirect($path){

	    // セッション開始
	    @session_start();

	    if(!isset($_SESSION['username'])){
			http_response_code(403);
	        require $path;
	        exit;
	    }

	}


?>
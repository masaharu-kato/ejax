<?php
namespace Auth;
	require_once SRC_ROOT.'/utils/uri.php';
	require_once DATA_ROOT.'/preferences/urls.php';

	//	Check authorization for systematic use
	//	If it is not authorized, it returns 403 response.
	function requiredForSystem(){

	    @session_start();

	    if(!isset($_SESSION['username'])){
			http_response_code(403);
	        exit;
	    }

	}

	//  Check authorization for users' use
	//	If it is not authorized, it redirects to login page.
	function requiredForUser(){

	    @session_start();

		$_SESSION['original_uri'] = \URI\getFullURI();

	    if(!isset($_SESSION['username'])){
	        header('Location: '.URL_LOGIN); // 移動先
	        exit;
	    }

	}

	//  Check if already authorized for users' use
	//	Put this to login page, to redirect index page if already authorized.
	function checkAlreadyAuthedForUser($original_url){

	    @session_start();

	    if(isset($_SESSION['username'])){
	        header('Location: '.$original_url); // 移動先  
	        exit;
	    }
	    
	}



	//	Delete cookie for having current session ID
//	function unsetSessionCookie() {
//		setcookie(session_name(), '', 1, null, SESSION_DOMAIN);
//	}

?>
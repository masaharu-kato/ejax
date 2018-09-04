<?php
namespace Ejax\Auth;
	require_once DATA_ROOT.'/preferences/urls.php';
	require_once SRC_ROOT.'/auth/funcs/isAuthed.php';
	require_once SRC_ROOT.'/utils/http/request.php';
	require_once SRC_ROOT.'/utils/http/response.php';

	use Ejax\Http\Request as Req;
	use Ejax\Http\Response as Res;

	/**
	 * requiredForSystem
	 * 	Check authorization for systematic use
	 * 	If it is not authorized, it returns 403 response.
	 * @return void
	 */
	function requiredForSystem() : void {

	    @session_start();

	    if(!isAuthed()) Res\statusCode(403);

	}


	/**
	 * requiredForUser
	 *   Check authorization for users' use
	 *   If it is not authorized, it redirects to login page.
	 * @return void
	 */
	function requiredForUser() : void {

	    @session_start();

		$_SESSION['original_uri'] = Req\getFullURI();

	    if(!isAuthed()) Res\redirect(URL_LOGIN);

	}


	//	Delete cookie for having current session ID
//	function unsetSessionCookie() {
//		setcookie(session_name(), '', 1, null, SESSION_DOMAIN);
//	}

?>
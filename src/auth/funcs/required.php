<?php
namespace Ejax\Auth;
	require_once DAT_PREF_DIR.'/urls.php';
	require_once SRC_ROOT.'/auth/funcs/isAuthed.php';
	require_once SRC_ROOT.'/utils/http/request.php';
	require_once SRC_ROOT.'/utils/http/response.php';

	use Ejax\Http\Request as Req;
	use Ejax\Http\Response as Res;

	/**
	 * requiredForUser
	 *   Check authorization for users' use
	 *   If it is not authorized, it redirects to login page.
	 * @return void
	 */
	function requiredForUser() : void {

	    @session_start();

		$_SESSION['original_uri'] = Req\getFullURI();

	    if(!isAuthed()) Res\exitWithRedirect(URL_LOGIN);

	}


	//	Delete cookie for having current session ID
//	function unsetSessionCookie() {
//		setcookie(session_name(), '', 1, null, SESSION_DOMAIN);
//	}

?>
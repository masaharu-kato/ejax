<?php
namespace Ejax\Auth;
	require_once SRC_ROOT.'/auth/funcs/token.php';
	require_once SRC_ROOT.'/utils/h_wrapper.php';
	require_once DAT_PREF_DIR.'/urls.php';
/**
 *  function getLogoutURL
 *    get url for logout
 * 
 *  @return string : url for logout
 */
	function getLogoutURL() : string {
		return URL_LOGOUT."?token=".\h(generate_token());
	}

?>
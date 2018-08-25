<?php
namespace Auth;
	require_once __DIR__.'/token.php';
	require_once __DIR__.'/../utils/h_wrapper.php';
	require_once __DIR__.'/../../_constants/urls.php';

	function getLogoutURL() {
		return URL_LOGOUT."?token=".\h(generate_token());
	}

?>
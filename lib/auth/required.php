<?php
namespace Auth;
	require_once __DIR__.'/token.php';
	require_once __DIR__.'/session.php';
    require_once __DIR__.'/logout.php';
	require_once __DIR__.'/../../_constants/urls.php';

	require_logined_session(URL_LOGIN);
 ?>
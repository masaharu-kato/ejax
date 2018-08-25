<?php
namespace _Request\Error;
    require_once __DIR__.'/../base/auth/session.php';
    require_once __DIR__.'/error_file.php';

//  認証がされていなければエラーページへ飛ばす
    \Auth\require_auth_or_redirect(getFilePath(403));
?>
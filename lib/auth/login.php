<?php
namespace Auth;
    require_once __DIR__.'/token.php';
    require_once __DIR__.'/session.php';
    require_once __DIR__.'/../utils/h_wrapper.php';
    require_once __DIR__.'/../../_constants/users.php';
    require_once __DIR__.'/../../_constants/urls.php';

//  ダミーのハッシュ
    const dummy_hash = '$2y$10$vi4sizf0pl5fgwtzogw19bzcqb.vi4sizf0pl5fgwtzogw19bzcqb';

//  ログイン処理
    function login(string $_username, string $_password, string $token) {

        $original_page = $_SESSION['.ejax_original_uri'] ?? URI_INDEX;

    //  ログイン済みの場合に、元いたページ飛ばす
        require_unlogined_session($original_page);
        
        $username = mb_strtolower(\h($_username));    //  ユーザー名はすべて小文字として扱う
        $password = \h($_password);

        if($username && $password && $token) {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(validate_token($token) && password_verify($password, user_password_hashes[$username] ?? dummy_hash)){
                    session_regenerate_id(true);        //  セッションIDを新しくする

                    $_SESSION['.ejax_username'] = $username;  //  ユーザー名を設定
                    $_SESSION['is_admin'] = is_admin($username);
                    $_SESSION['is_editable'] = is_admin($username);
                    
                    header('Location: '.$original_page);     //  移動先
                    exit;
                }
                http_response_code(403);    //  403 Forbidden
            }
            else {
                http_response_code(405);
            }

        }
    }
?>
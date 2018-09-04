<?php
namespace Ejax\Auth;
    require_once DAT_PREF_DIR.'/urls.php';
    require_once SRC_ROOT.'/auth/funcs/required.php';
    require_once SRC_ROOT.'/auth/funcs/token.php';
    require_once SRC_ROOT.'/utils/h_wrapper.php';
    require_once SRC_ROOT.'/utils/http/response.php';

    use Ejax\Http\Response as Res;

//  Dummy Hash
    const dummy_hash = '$2y$10$vi4sizf0pl5fgwtzogw19bzcqb.vi4sizf0pl5fgwtzogw19bzcqb';

/**
 *  function login
 *    Login Process
 * 
 *  @param string   $_username: raw username
 *  @param string   $_password: raw password
 *  @param string   $_token   : token text generated in login page
 *  @param function $getPasswordHash   : function to get password hash from username
 *  @param function $getUserInformation: function to get user information as associated array to set to session
 * 
 *  @return void
 */
    function login(string $_username, string $_password, string $token, callable $getPasswordHash, callable $setUserToSession) : void {

	    @session_start();

    //  Full url of original page
        $original_page = $_SESSION['.ejax_original_uri'] ?? URI_INDEX;

    //  If already authorized, redirect to original page
	    if(isAuthed()) Res\exitWithRedirect($original_page);
        
    //  Treat as lower cases in username
        $username = mb_strtolower(\h($_username));

        $password = \h($_password);

    //  if all of username, password, token is not set, do nothing
        if(!$username || !$password || !$token) return;

    //  if request method is not POST, return 405 Invalid Method response
        if($_SERVER['REQUEST_METHOD'] != 'POST') http_response_code(405);

    //  if token or password is not valid, return 403 Forbidden response
        if(!validate_token($token) || !password_verify($password, $getPasswordHash($username) ?? dummy_hash)) {
            http_response_code(403);
        }


    //  Regenerate session id
        session_regenerate_id(true);

    //  Set flag of authorized
        $_SESSION['.ejax/authed'] = true;

    //  TODO: 
        $getUserInformation($username);
        
    //  Redirect to original page
        Res\exitWithRedirect($original_page);
        
    }
?>
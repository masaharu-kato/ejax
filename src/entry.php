<?php
namespace Ejax\Http\Entry;
require_once SRC_ROOT.'/auth/funcs/required.php';
require_once SRC_ROOT.'/utils/http/request.php';
require_once SRC_ROOT.'/utils/http/response.php';

use Ejax\Http\Request  as Req;
use Ejax\Http\Response as Res;

//  Require authorization and ajax access (if necessary)
    if(F_DEFAULT_AUTH && !(isAuthed() && Req\isAjax())) Res\exitWithStatus('403');

//  process for request URI
    $__uri = Req\getURI();                   //  要求URI ( / から始まり、パラメータも含む)
    $__uri_no_params = strtok($__uri, '?');    //  パラメータを除いたURI
    $__uri_params = strtok('') ?: '';               //  パラメータ部分

    $__uri_dirs = substr($__uri_no_params, 1);  //  先頭のスラッシュを除去したURI

    $__uri_first_dir  = strtok($__uri_dirs, '/');  //  1番目のディレクトリ
    $__uri_rest_dirs = strtok('') ?: '';                 //  2番目以降のディレクトリ

//  Response for request of each kind
//   calution: Do not functionalize this process!
//       (The scope of requiring file changes and we don't use global variables or functions)
    switch($__uri_first_dir) {

    //  AJAX access
    case '.ajax':

    //  output content type
        Res\outContentType();
        require DAT_AJAX_DIR.toRealPath($__uri_rest_dirs);
        return;
    

    //  File access
    case '.files':

        require_once SRC_ROOT.'/file/read.php';
        \Ejax\File\read(DAT_FILE_DIR.toRealPath($__uri_rest_dirs));
        return;


    //  API access
    case '.api':

        $splited_path = explode('/', $pathtext);

        $file_dir = $this->getFilePath($splited_path);
        if($file_dir == null) return Res\exitWithStatus('404');
        
        require_once __DIR__.'/../'.$file_dir;

        $func = 'API\\Current\\'.$method;	//	name of function
        if(!function_exists($func)) return ['error' => 'Unknown method'];
        $data = $func($splited_path, (object)$params);

        return;
        
    }

?>
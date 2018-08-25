<?php
namespace _Request;
require_once __DIR__.'/_error.php';

//  要求URIに関する処理
    $__uri = $_SERVER['REQUEST_URI'];                   //  要求URI ( / から始まり、パラメータも含む)
    $__uri_without_parameters = strtok($__uri, '?');    //  パラメータを除いたURI
    $__uri_parameters = strtok('') ?: '';               //  パラメータ部分

    $__uri_directories = substr($__uri_without_parameters, 1);  //  先頭のスラッシュを除去したURI

    $__uri_first_directory  = strtok($__uri_directories, '/');  //  1番目のディレクトリ
    $__uri_rest_directories = strtok('') ?: '';                 //  2番目以降のディレクトリ

//  各種アクセスの処理
//   注意:ここは関数化したらダメ！！
//       (requireしてるファイルのスコープが関数内になり、関数や変数の利用に影響が出るため)
    switch($__uri_first_directory) {

    //  AJAXアクセス
    case '.ajax':
        require_once __DIR__.'/__ajax_list.php';
        $__access_ajax_kind = Ajax\__list[$__request_path[2] ?? ''] ?? null;
        if($__access_ajax_kind === null) throw new \Exception('Unknown kind of ajax.');
        require __DIR__.'/ajax.php';
        break;
    
    //  ファイルアクセス
    case '.files':
        require_once __DIR__.'/../base/file/read.php';
        //  \File\read($__uri_rest_directories);
        http_response_code(404);
        require Error\getFilePath(404);
        break;

    //  APIアクセス
    case '.api':
        require_once __DIR__.'/api.php';
        echo API\query($_SERVER['REQUEST_METHOD'], $__uri_rest_directories);
        break;

    //  その他(通常ページ)
    default:
        require_once __DIR__.'/__path_list.php';
        if(!isset(Http\__list[$__uri_directories])){
            http_response_code(404);
            require Error\getFilePath(404);
            break;
        }
        require __DIR__.'/../'.Http\__list[$__uri_directories];
        break;

    }

?>
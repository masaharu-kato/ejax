<?php
namespace Ejax\Response\API;

    require_once SRC_ROOT.'/file/toRealPath.php';

    use Ejax\File as File;

    function main($rest_path) {

    //  Check authorization if necessary
        if(!F_DEFAULT_AUTH && F_API_AUTH && !isAuthed()) Response\exitWithStatus(403);
        
    //  Proccess into real path
        list($real_path_data, $real_path, $src_path) = File\procRealPath(DAT_API_DIR, $rest_path);
        
    //  load script on path
        include $src_path;

    //  name of function
        $func = 'EjaxData\\API\\'.implode('\\', $real_path_data).'\\'.$method;

    //  if there is no function for given method, exit with error 405 (Method not allowed) 
        if(!function_exists($func)) return Response\exitWithStatus(405);

    //  get parameters
        $params = Request\getInput();

    //  Call API function and get response
        $data = $func($splited_path, (object)$params);

    //  output data as json
        echo json_encode($data, \JSON_UNESCAPED_UNICODE);

    }
?>
<?php
namespace Ejax\File;
    require_once SRC_ROOT.'/utils/http/response.php';
    require_once SRC_ROOT.'/file/toRealPath.php';

    use Ejax\File as File;
    use Ejax\Http\Response as Response;


    function procRealPath($base_dir, $rest_path) : array {

    //  Calc real relative path data
        $real_path_data = File\toRealPathData($rest_path);
        if($real_path_data == null)  return Response\exitWithStatus(404);

    //  Calc real relative path and absolute script path
        $real_path  = File\toRealPathFromData($real_path_data);
        $src_path = $base_dir.$real_path;
        if(!\file_exists($src_path)) return Response\exitWithStatus(404);

        return [$real_path_data, $real_path, $src_path];

    }

?>
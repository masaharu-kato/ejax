<?php
namespace Ejax\Response\Ajax;
    require_once SCR_ROOT.'/file/read.php';
    require_once SRC_ROOT.'/file/toRealPath.php';

    use Ejax\File as File;

    function main($path) {
        
    //  Check authorization if necessary
        if((!F_DEFAULT_AUTH && F_AJAX_AUTH && !isAuthed()) || Req\isAjax()) Response\exitWithStatus(403);

    //  Proccess into real path
        list($real_path_data, $real_path, $src_path) = File\procRealPath(DAT_FILES_DIR, $rest_path);

    //  Include script file
        include $src_path;
        
    }
?>
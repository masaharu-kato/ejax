<?php
namespace Ejax\Response\Files;
    require_once SCR_ROOT.'/file/read.php';
    require_once SRC_ROOT.'/file/toRealPath.php';

    use Ejax\File as File;

    function main($path) {
        
    //  Check authorization if necessary
        if(!F_DEFAULT_AUTH && F_FILE_AUTH && !isAuthed()) Response\exitWithStatus(403);

    //  Proccess into real path
        list($real_path_data, $real_path, $src_path) = File\procRealPath(DAT_FILES_DIR, $rest_path);

        \Ejax\File\read(DAT_FILE_DIR.toRealPath($src_path));
        
    }
?>
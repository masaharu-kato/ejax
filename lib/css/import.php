<?php
namespace CSS;
    require_once __DIR__.'/../../_constants/path.php';

    function import($files) {
        echo '<style>';
        echo "\n";

        if(is_array($files)) {
            foreach($files as $file){
                require_once PROJECT_DIR.$file;
                echo "\n";
            }
        }else{
            require_once PROJECT_DIR.$files;
        }
        
        echo "\n";
        echo '</style>';
    }

?>
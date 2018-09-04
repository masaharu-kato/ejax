<?php
namespace Ejax\File;
  
    /**
     *  read
     *  read file and output as page
     * 
     * @param string $path: filepath in server
     * @param string $type: filetype
     * @param bool   $f_inline: whether view on browser (true:view on browser, false:make download)
     */
    function read(string $path, string $type, bool $f_inline = true) : void {

        $path_parts = pathinfo($path);

        header('Content-Type: ' . $type);
        header('Content-Disposition: '.($f_inline ? 'inline': 'attachment').'; filename="' . $path_parts['basename'] . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);

    }

?>
<?php
namespace Ejax\File;

    /**
     * getInsidePath
     * 
     * @param string $base_dir : base absolute directory path
     * @param string $path     : relative path baesd on $base_dir
     * 
     * @return string|null : if path is inside $base_dir, return its path, or return null.
     */
    function getInsidePath(string $base_dir, string $path) : string {

    //  change directory to base directory
        \chdir($base_dir);

    //  change directory to relative directory
        \chdir(dirname($rel_dir));

    //  


    }

?>
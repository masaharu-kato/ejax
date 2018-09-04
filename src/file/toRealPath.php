<?php
namespace Ejax\File;


    function toRealPathDataByData(array $original_path) : string {

        $real_path = [];

        foreach($original_path as $cdir) {

        //  check current direcoty name
            switch($cdir) {

            //  if it is empty, treat as error
            case '': return null; 

            //  '.' means current directory
            case '.': continue;

            //  '..' means parent directory
            case '..':
            //  delete last directory
                $last_dir = array_pop($real_path);
            //  if it fails, treat as invalid path error
                if($last_dir === NULL) return null;

            default:
            //  push current directory into real path
                array_push($real_path, $cdir);

            }
            
        }

        return $real_path;

    }

    


    function toRealPathByData(array $path) : string {

        return toRealPathDataByData(explode('/', $path));

    }

    
    function toRealPathFromData(array $data) : string {

        return '/'.implode('/', $data);
        
    }

    function toRealPath(string $path) : string {

        return toRealPathFromData(toRealPathByData($path));
        
    }



?>
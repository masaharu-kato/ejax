<?php
namespace Ejax\Response;
require_once SRC_ROOT.'/auth/funcs/required.php';


//  Require authorization and ajax access (if necessary)
    if(F_DEFAULT_AUTH && !isAuthed()) Res\exitWithStatus('403');


//  process for request URI
    $__uri = Request\getURI();                      //  request URI ('/' in first character, includes parameters)
    $__uri_no_params = strtok($__uri, '?');         //  request URI without parameters
    $__uri_params = strtok('') ?: '';               //  parameters

    $__uri_dirs = substr($__uri_no_params, 1);      //  request URI without first '/'

    $__uri_first_dir  = strtok($__uri_dirs, '/');   //  first directory
    $__uri_rest_dirs = strtok('') ?: '';            //  rest directory (URI without first directory). there is no first '/'


//  Response for request of each kind
//   calution: Do not functionalize this process!
//       (The scope of requiring file changes and we don't use global variables or functions)
    switch($__uri_first_dir) {

    //  AJAX access
    case '.ajax':
        require_once __DIR__.'/ajax.php';
        return  Ajax\main($__uri_rest_dirs);

    //  File access
    case '.files':
        require_once __DIR__.'/files.php';
        return Files\main($__uri_rest_dirs);

    //  API access
    case '.api'  :
        require_once __DIR__.'/api.php';
        return   API\main($__uri_rest_dirs);
        
    }

?>
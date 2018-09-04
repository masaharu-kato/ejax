<?php
namespace Ejax\Http\Response;
    
    /**
     * redirect
     * set redirection as http response
     * 
     * @param string $url : url for redirect
     * 
     * @return void
     */
    function redirect(string $url) : void {
        header('Location: '.$url); // 移動先  
        exit;
    }


    /**
     * statusCode
     * set http status code only as http response
     * 
     * @param int $code : http status code for response
     * 
     * @return void
     */
    function statusCode(int $code) : void {
        http_status_code($code);
        exit;
    }

?>
<?php
namespace Ejax\Http\Response;

    /**
     * outContentType
     * output Content-type header 
     * 
     * @return void
     */
    function outContentType() : void {
        header("Content-type: text/plain; charset=UTF-8");
    }
    
    /**
     * redirect
     * set redirection as http response
     * 
     * @param string $url : url for redirect
     * 
     * @return void
     */
    function exitWithRedirect(string $url) : void {
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
    function exitWithStatus(int $code) : void {
        http_status_code($code);
        exit;
    }

?>
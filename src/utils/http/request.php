<?php
namespace Ejax\Http\Request;

    /**
     * getRawInput
     * @return string : get curret input as text
     */
    function getRawInput() : string {
        return file_get_contents('php://input');
    }

    /**
     * getInput
     * @return array : get current input as associative array
     */
    function getInput() : array {
        $ret = [];
        parse_str(getRawInput(), $ret);
        return $ret;
    }

    /**
     * getURI
     * @return string : URI after host name (begin with '/')
     */
    function getURI() : string {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * isHttps
     * @return bool : whether current http request is ssl or not
     */
    function isHttps() : bool {
        return isset($_SERVER['HTTPS']);
    }

    /**
     * getHost
     * @return string : Host name of current http request
     */
    function getHost() : string {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * getFullURI
     * @return string : Full uri of current http request
     */
	function getFullURI() : string {
		return (isHttps() ? 'http://' : 'https://') . getHost() . getURI();
    }

    /**
     * getMethod
     * @return string : Method of current http request
     */
    function getMethod() : string {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * isAjax
     * @return bool : whether request is by Ajax
     */
    function isAjax() : bool {
        return strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest';
    }

?>
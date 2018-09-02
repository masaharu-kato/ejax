<?php
namespace Request;

    function getInput() {
        $ret = [];
        parse_str(file_get_contents('php://input'), $ret);
        return $ret;
    }

    function getURI() {
        return $_SERVER['REQUEST_URI'];
    }

    function isHttps() {
        return isset($_SERVER['HTTPS']);
    }

    function getHost() {
        return $_SERVER['HTTP_HOST'];
    }

	function getFullURI() {
		return (isHttps() ? 'http://' : 'https://') . getHost() . getURI();
    }

    function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

?>
<?php
namespace _Request\Error;
require_once __DIR__.'/__error_list.php';

    function getFilePath($code) {
        return __DIR__ . '/../' . (__list[$code] ?? __list[''] ?? '');
    }
    
?>
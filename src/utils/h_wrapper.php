<?php
namespace Ejax;
    /**
     * h
     * wrapper of htmlspecialchars
     * escape special characters in text for HTML or SQL query.
     * 
     * @param string $str: text for escape
     * 
     * @return string : escaped text
     * 
     */
    function h(string $str) : string {
        return \htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

?>
<?php
namespace Ejax\DBO;

    /*
     *  Exception
     *  例外クラス
     */
    class Exception extends \Exception {
        
        public function __construct($message, $code = 0, \Exception $previous = null) {
            parent::__construct('[SQL Exception]'.$message, $code, $previous);
        }

    };

?>
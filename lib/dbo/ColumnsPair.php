<?php
namespace Ejax\DBO;
require_once __DIR__.'/Columns.php';

    class ColumnsPair {
        private $columns_from;  /* class Columns */
        private $columns_to;    /* class Columns */

        function __construct(Columns $columns_from, Columns $columns_to) {
            $this->columns_from = $columns_from;
            $this->columns_to   = $columns_to;
        }
        
    };

?>
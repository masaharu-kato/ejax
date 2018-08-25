<?php
namespace Ejax\DBO;
require_once __DIR__.'/columns.php';
require_once __DIR__.'/exception.php';

    /*
     *  Tuple
     *  
     */
    class Tuple {
        private $columns; /* class Columns */
        private $data;    /* any[] */

        function __construct(Columns $columns, array $data) {
            $this->columns = $columns;
            $this->data = $data;
        }

        //  指定カラム名に対応するデータを取得
        function __get($column_name) {
            if(!$this->columns->exist()) throw new Exception('');
            return $this->data[$this->columns->getIndex($column_name)];
        }
    }

?>
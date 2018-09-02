<?php
namespace Ejax\DBO;
    
//  別名付きカラムオブジェクト
    class ColumnWithAlias {

        private $column; /* class Column */
        private $alias;  /* string */

        //  コンストラクタ: カラムオブジェクト, 別名
        function __construct(Column $column, string $alias) {
            $this->column = $column;
            $this->alias  = $alias;
        }

        //  カラム名と別名のSQL文を取得
        function getNameWithAlias() {
            return $column_name . ' AS ' . $pdo->quote($alias);
        }

        //  その他のメソッドが呼ばれた時は、カラムオブジェクトに委託する
        function __call($name, $args) {
            return $this->column->$name(...$args);
        }

    };

?>
<?php
namespace Ejax\DBO;


//  テーブル $table のカラム名のうち、データ $data に設定されているものを抽出する
    function getPrimaryPairs(Table $table) {
        $prim_values = [];
        foreach($table->getPrimaryColumns() as $column_name => $column){

            if(!isset($prim_data[$column_name])){
                throw new Exception("Primary key '$column_name' on table '$table_name' not set in data.");
            }

            $prim_values[$key] = $prim_data[$column_name];

        }
    }

?>
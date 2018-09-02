<?php
namespace Ejax\DBO;
require_once __DIR__.'/table.php';

    /**
     * insert
     * 
     * テーブル $table に、データ $data を挿入する。
     * データのうち、テーブルに存在するカラム名の値のみが利用される。
     * 
     */
    function insert(Table $table, array $data) : \PDOStatement {

        //  テーブル $table のカラム名のうち、データ $data に設定されているものを抽出する
        $values = [];
        foreach($table->getColumns() as $column_name => $column){
            if(isset($data[$column_name])) {
                $values[$key] = $data[$column_name];
            }
        }

        $pdo = $table->getDatabase()->getPDO();

        $keys = array_keys($values);

        $st = $pdo->prepare(
            'INSERT INTO '.$table->getName()
                //  カラム名を , で繋げる
                .'('.implode(',', $keys).')' 
                //  カラム名の先頭に : を付加したものを , で繋げる
                .' VALUES('.implode(',', array_map($keys, function($key){ return ':'.$key; })).')'
        );

        return $st->execute($values);

    }

?>
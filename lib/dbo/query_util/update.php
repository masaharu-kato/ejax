<?php
namespace Ejax\QueryUtil;
require_once __DIR__.'/utils.php';
require_once __DIR__.'/table.php';
require_once __DIR__.'/column.php';
require_once __DIR__.'/exception.php';

    /**
     * update
     * 
     * テーブル $table で、データ $data を更新する。
     * $data に設定されている主キーの値が利用される。
     * $data にすべての主キーの値が設定されていない場合・テーブルに主キーがない場合、例外を投げる
     * 
     */
    function update(Table $table, array $data) : \PDOStatement {

        $table_name = $table->getName();

        //  テーブル $table のカラム名のうち、データ $data に設定されているものを抽出する
        $pvalues = [];
        $nvalues = [];
        foreach($table->getColumns() as $column_name => $column){

            if($column instanceof PrimaryColumn) {
                if(isset($data[$column_name])) {
                    $pvalues[$key] = $data[$column_name];
                }
                else {
                    throw new Exception("Primary key '$column_name' on table '$table_name' not set in data.");
                }
            }
            else {
                if(isset($data[$column_name])) {
                    $nvalues[$key] = $data[$column_name];
                }
            }

        }

        if(!$pvalues) throw new Exception("Table '$table_name' doesn't have any primary keys.");

        $pdo = $table->getDatabase()->getPDO();

        $nkeys = array_keys($nvalues);
        $pkeys = array_keys($pvalues);

        $st = $pdo->prepare(
            'UPDATE '.$table_name
                //  「カラム名 = :カラム名」を , で繋げる
                .' SET '  .implode(',', array_map($nkeys, function($key){ return $key.'=:'.$key; }))
                .' WHERE '.implode(',', array_map($pkeys, function($key){ return $key.'=:'.$key; }))
        );

        return $st->execute($nvalues);

    }

?>
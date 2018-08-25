<?php
namespace Ejax\DBO;
require_once __DIR__.'/utils.php';
require_once __DIR__.'/table.php';
require_once __DIR__.'/column.php';
require_once __DIR__.'/exception.php';

    /**
     * [Ejax\SQL] delete
     * 
     * テーブル $table で、データ $prim_data を取得する
     * 
     * @param Table $table
     *   テーブルオブジェクト。予め作成したデータベースオブジェクトから取得する。
     * 
     * @param array  $prim_data  
     *   主キーのデータ。すべての主キーを、キーにカラム名, 値にそのカラムの値を指定する。そうでない場合は例外を投げる。
     * 
     * @return \PDOStatement
     *   削除の実行後の状態を返す。trueと評価されれば成功。
     * 
     * 
     */
    function delete(Table $table, array $prim_data) : \PDOStatement {

        $table->requirePrimaryColumn();

        $values = getPrimaryValues($table, $prim_data);

        $st = $table->getDatabase()->getPDO()->prepare(
            'DELETE FROM '.$table->getName()
                .' WHERE '.implode(',', array_map(array_keys($values), function($key){ return $key.'=:'.$key; }))
        );

        return $st->execute($values);

    }

?>
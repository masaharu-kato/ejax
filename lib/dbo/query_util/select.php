<?php
namespace Ejax\DBO;
require_once __DIR__.'/utils.php';
require_once __DIR__.'/table.php';
require_once __DIR__.'/column.php';
require_once __DIR__.'/exception.php';

    /**
     * [Ejax\SQL] select
     * 
     * テーブル $table で、データ $prim_data を取得する
     * 
     * @param Table $table
     *   テーブルオブジェクト。予め作成したデータベースオブジェクトから取得する。
     * 
     * @param array  $prim_data  
     *   主キーのデータ。すべての主キーを、キーにカラム名, 値にそのカラムの値を指定する。そうでない場合は例外を投げる。
     * 
     * @param Columns|array|true  $select_columns
     *   取得するカラム。Columnsオブジェクトまたはそのコンストラクタ引数(複数の場合は配列)を指定する。
     *   @see Columnsのコンストラクタ
     * 
     * @return array|null $data
     *   取得したデータを返す。データが存在しなかった場合は null を返す。
     * 
     */
    function select(Table $table, array $prim_data, $select_columns = true) {

        if(!$table->hasPrimaryColumn()) throw new Exception("Table '$table_name' doesn't have any primary keys.");
        $table_name = $table->getName();

        //  テーブル $table のカラム名のうち、データ $data に設定されているものを抽出する
        $prim_values = [];
        foreach($table->getPrimaryColumns() as $column_name => $column){
            if(!isset($prim_data[$column_name])) throw new Exception("Primary key '$column_name' on table '$table_name' not set in data.");
            $prim_values[$key] = $prim_data[$column_name];
        }


        

        $st = $table->getDatabase()->getPDO()->prepare(
            'SELECT '.$column_text_all
            .' FROM '.$table_name
            .' WHERE '.implode(',', array_map(array_keys($prim_values), function($key){ return $key.'=:'.$key; }))
        );

        if(!$st->execute($nvalues)) throw new Exception('Failed to execute select statement.');

        return $st->fetch();
    }

?>
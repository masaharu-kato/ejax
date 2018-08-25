<?php
namespace Ejax\DBO;
require_once __DIR__.'/__class_loader.php';

    /*
     *  Columns
     *  複数カラムオブジェクト
     *  (同一テーブル内の)複数のカラムを保持するクラス
     */
    class Columns {
        private $table;   /* class Table */
        private $columns; /* class Column[] */
        
        
    /**
     * [Ejax\SQL::Columns] __construct
     * 
     * @param Table $table
     *   テーブルオブジェクト。予め作成したデータベースオブジェクトから取得する。
     * 
     * @param array|true  $column_names
     *   カラム名の配列。別名を指定する場合、配列のキーに別名, 値にカラム名を指定する。
     *   trueを指定すると、全てのカラムをそのままの名前で取得する。
     * 
     * @param bool $use_all_columns
     *   $columnsの全てのカラムを取得するかどうか。既定値はture。
     *   trueを指定すると、$columnsの中に取得できないカラムがある場合に例外を投げる。falseを指定するとそのようなカラムは無視される。
     * 
     */
        function __construct(Table $table, $column_names = true, $use_all_columns = true) {

            $this->table = $table;

            foreach($this->colums as $alias => $column_name) {

                if(!$table->exist($column_name)) {
                    if($use_all_columns){
                        throw new Exception("Column '$column_name' not found on '$table_name'.");
                    }
                }
                else{
                    if(is_numeric($alias)) {
                        $columns_text[] = $table->$column_name;
                    }
                    else {
                        $columns_text[] = new ColumnWithAlias($table->$column_name, $alias);
                    }
                }

            }

        }


    //  全ての主キーを指定して1つのタプルを取得
        function get($prim_data) : Tuple {
            
        }
        
    //  条件を指定して複数のタプルを取得
        function find($wheres) : Tuples {
            
        }

    //  カラム名をテキストにしたものを返す
        function __toString() : string {
        }


    };

?>
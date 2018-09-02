<?php
namespace Ejax\DBO;
require_once __DIR__.'/Database.php';
require_once __DIR__.'/Columns.php';
require_once __DIR__.'/ColumnsPair.php';

    /*
     *  Table
     *  テーブルオブジェクト
     */
    class Table extends ObjectBase {
        private $columns;       /* string => class Column[] */
        
        private $uniques;       /* class Columns[] */
        private $indexes;       /* class Columns[] */
        private $references;    /* class ColumnsPair[] */

        
        function __construct(Database $database_obj, string $table_name, array $data) {

            parent::__construct($database_obj, $table_name);

            //  カラムオブジェクトの作成
            foreach($data['Columns'] as $column_name => $column_data) {
                $this->columns[$column_name] = new Column($this, $column_name, $column_data);
            }

            //  複数カラムのUnique制約を生成
            foreach($data['Uniques'] as $column_names) {
                $this->uniques[] = $this->getColumnsOf($column_names);
            }

            //  複数カラムのIndex制約を生成
            foreach($data['Indexes'] as $column_names) {
                $this->indexes[] = $this->getColumnsOf($column_names);
            }

            //  複数カラムの外部キー制約を生成
            foreach($data['References'] as $data) {
                $this->indexes[] = new ColumnsPair($this->getColumnsOf($data['from']), $this->getColumnsOf($data['to']));
            }

        }

        //  カラムオブジェクトの配列を取得
        function getColumns() : array {
            return $this->columns;
        }

        //  指定された名前のカラムが存在するかを返す
        function exist(string $column_name) : bool {
            return isset($this->columns[$column_name]);
        }

        //  カラムオブジェクトを取得する。
        //  存在しない場合は例外を返す
        function __get(string $column_name) : Column {
            if(!$this->exist($column_name)) throw new Exception('Unknown column name.');
            return $this->columns[$column_name];
        }

        // //  データベースオブジェクトを取得
        // function getDatabase() : Database {
        //     return $this->getBase();
        // }


        //  複数のカラムをまとめてオブジェクトとして取得
        function getColumnsOf($column_names) : Columns {
            return new Columns($this, $column_names, true);
        }

        //  getColumnsOf のエイリアス
        function columns(...$column_names) : Columns {
            return getColumnsOf($column_names);
        }

        //  データを挿入する
        function insert(array $data) : \PDOStatement {
            require_once __DIR__.'/query_util/insert.php';
            return QueryUtil\insert($this, $data);
        }

        //  データを更新する
        function update(array $data) : \PDOStatement {
            require_once __DIR__.'/query_util/update.php';
            return QueryUtil\update($this, $data);
        }

        //  データを削除する
        function delete(array $primary_data) : \PDOStatement {
            require_once __DIR__.'/query_util/delete.php';
            return QueryUtil\delete($this, $primary_data);
        }


    };

?>
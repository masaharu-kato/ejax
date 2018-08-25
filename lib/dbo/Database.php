<?php
namespace Ejax\DBO;
require_once __DIR__.'/table.php';
require_once __DIR__.'/exception.php';

    /*
     *  Database
     *  データベースオブジェクト
     */
    class Database extends ObjectBase {
        private $pdo;           /* class \PDO */
        private $database_name; /* string */
        private $tables;        /* class Table[] */
        
        //  コンストラクタ: PDOオブジェクト, データベース, テーブル情報
        //  テーブル情報は、テーブルオブジェクトのコンストラクタ引数の配列。
        function __construct(\PDO $pdo, string $database_name, array $tables_data) {

            // set pdo object
            $this->pdo = $pdo;
            $this->database_name = $database_name;

            // create table objects from array of tables' data
            foreach($tables_data as $table_name => $table_data) {
                $this->tables[$table_name] = new Table($this, $table_name, $table_data);
            }

        }

        //  所属データベースオブジェクト(自分自身)を取得する
        function getDB() : Database {
            return $this;
        }

        //  PDOオブジェクトを取得
        function getPDO() : \PDO {
            return $this->pdo;
        }

        //  テーブルオブジェクトの配列を取得
        function getTables() : array {
            return $this->tables;
        }

        //  その名前のテーブルが存在するか返す
        function exist(string $table_name) : bool {
            return isset($this->tables[$table_name]);
        }

        //  テーブルオブジェクトを取得
        //  「$db->テーブル名」のように使う ($dbはこのオブジェクト)
        function __get(string $table_name) : Table {
            if(!$this->exist($table_name)) throw new Exception('Unknown table name.');
            return $this->tables[$table_name];
        }

        //  データベース名を取得
        function getName() : string {
            return $this->database_name;
        }


        //  カラム名を表す文字列からカラムオブジェを取得
        function getColumn($text) : Column {
            $pos_dot = strpos($text, '.');
            $table_name  = substr($text, 0, $pos_dot);
            $column_name = substr($text, $pos_dot + 1);
            return $this->$table_name->$column_name;
        }

    };

?>
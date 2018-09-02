<?php
namespace Ejax\DBO;

    /**
     * Update one tuple
     *  
     * @param \PDO   $pdo
     * @param string $table  table name
     * @param array  $tuple  one tuple data [column name => column value]
     * @param string|array $primary_key  primary key(s) name.  default is 'id'.
     * 
     * @return \PDOStatement
     */
    function update($pdo, $table, $tuple, $primary_key = 'id') {
        return $pdo->query(getQueryText_update($table, $tuple, $id_key));
    }

    /**
     * Update one tuple
     *  
     * @param \PDO   $pdo
     * @param string $table  table name
     * @param array  $tuple  one tuple data [column name => column value
     * @param string|array $primary_key  primary key(s) name.  default is 'id'.
     * 
     * @return \PDOStatement
     */
    function update_multi($pdo, $table, $tuples, $id_key = 'id') {
        $sqltext = '';
        foreach($tuples as $tuple) $sqltext .= getQueryText_update($table, $tuple, $id_key).';';
        return $pdo->query($sqltext);
    }

//  テーブル名とカラムの連想配列から、SQL文を生成する
    function getQueryText_update($table, $tuple, $id_key) {

        $isfirst = true;

        $sqltext = "UPDATE $table SET ";
        foreach($tuple as $key => $value){
            if($key == $id_key) continue;

            if($isfirst) $isfirst = false; else $sqltext .= ',';
            $sqltext .= \h($key)."='".\h($value)."'";

        }

        $sqltext .= ' WHERE '.\h($id_key)."='".\h($tuple[$id_key])."'";

        return $sqltext;

    }

?>
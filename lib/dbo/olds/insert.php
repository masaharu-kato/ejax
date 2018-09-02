<?php
namespace Ejax\DBO;

    /**
     * Insert one tuple
     *  
     * @param \PDO   $pdo
     * @param string $table  table name
     * @param array  $tuple  one tuple data [column name => column value]
     * 
     * @return \PDOStatement
     */
    function insert($pdo, $table, $tuple) {
        $pdo->query(getQueryText_insert($table, $tuple));
    }


    /**
     * Insert multiple tuple
     *  
     * @param \PDO   $pdo
     * @param string $table   table name
     * @param array  $tuples  multiple tuple data [[column name => column value]]
     * 
     * @return \PDOStatement
     */
    function insert_multi($pdo, $table, $tuples) {

        $sqltext = '';
        foreach($tuples as $columns) $sqltext .= getQueryText_insert($table, $columns).';';
        
        return $pdo->query($sqltext);
    }

    /**
     * Generate SQL for insert
     * 
     * @param string $table  table name
     * @param array  $tuple  one tuple data [column name => column value]
     * 
     * @return string generated sql text
     */
    function getQueryText_insert($table, $tuple) {

        $text_keys = '';
        $text_vals = '';

        $isfirst = true;
        foreach($tuple as $key => $val){
            
            if($isfirst){
                $isfirst = false;
            }else{
                $text_keys .= ',';
                $text_vals .= ',';
            }

            $text_keys .= $key;
            $text_vals .= "'".h($val)."'";

        }

        return "INSERT INTO $table($text_keys) VALUES($text_vals)";

    }

?>
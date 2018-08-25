<?php
namespace Ejax\DBO;

    /*
     * create_table
     * テーブルを作成する
     * 
     * 
     */

    function create_table(Table $table) {
        
        $pdo = $table->getDatabase()->getPDO();

        $sql = "CREATE TABLE ".$table->getQuotedName();
        
        //  テーブルのカラムに関する情報...
        $sql .= '(';

    //  各カラムの情報...
        foreach($table->getColumns() as $column){
            $sql .= $column->getCreateQuery() .',';
        }

    //  主キーの情報...
        $sql .= 'PRIMARY KEY (';
        foreach($table->getPrimaryColumns() as $column) $sqltext .= $column->getQuotedName();
        $sql .= '),';

    //  インデックスの情報...
        

        $sql .= ')';



    
    };

/*

    CREATE TABLE `order_items` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `order_id` int(11) NOT NULL,
 `item_id` int(11) NOT NULL,
 `number` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `order_id` (`order_id`,`item_id`),
 KEY `item_id` (`item_id`),
 CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
 CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8

*/

?>
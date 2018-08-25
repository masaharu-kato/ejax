<?php
namespace Ejax\DBO;

    class ObjectBase {

        private $base; /* base class (instanceof Object) */
        private $name; /* string */

        function __construct(ObjectBase $base, string $name) {
            $this->base = $base;
            $this->name = $name;
        }
        
        //  ベースオブジェクトを取得
        function getBase() {
            return $this->base;
        }

        //  所属データベースオブジェクトを取得
        function getDB() {
            return $this->base->getDB();
        }

        //  PDOを取得
        function getPDO() {
            return $this->getDB()->getPDO();
        }

        //  カラム名を取得
        function getName() {
            return $this->name;
        }

        //  引用符で囲んだカラム名を取得
        function getQuotedName() {
            return $this->getPDO()->quote($this->getName());
        }

    };

?>
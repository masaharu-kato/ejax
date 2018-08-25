<?php
namespace Ejax\DBO;
require_once __DIR__.'/Table.php';

    /*
     * Column
     * カラムオブジェクト
     */
    class Column extends ObjectBase {
        private $type;                          /* string */
        private $f_primary = false;             /* bool */
        private $f_auto_increment = false;      /* bool */
        private $references = [];               /* class Column[] */
        
        private $f_nullable;        /* bool */
        private $default_value;     /* any */
        private $comment;           /* string */

        function __construct(Table $table, string $column_name, array $options) {

            parent::__construct($table, $column_name);

            if($options['AutoIncrementPrimary'] ?? false) {
                $this->f_primary = true;
                $this->f_auto_increment = true;
            }
            else if($options['Primary'] ?? false) {
                $this->f_primary = true;
            }

            if(isset($options['References'])) {
                foreach($options['References'] as $reference_text) {
                    $this->references[] = $this->getDB()->getColumn($reference_text);
                }
            }

            $f_nullable    = $options['Nullable'] ?? false;
            $default_value = $options['Default' ] ?? null;
            $comment       = $options['Comment' ] ?? null;

        }

    };


?>
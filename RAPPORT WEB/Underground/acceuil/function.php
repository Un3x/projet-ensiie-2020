<?php
if(!function_exists('is_already_in_use')){
    function is_already_in_use($field,$value,$stable){
        global $db;
        $q = $db ->prepare("SELECT id FROM $table WHERE $field =$pseudo");
        $q->execute([$value]);
        $count = $q->rowCount();
        $q->closeCursor();

        return $count;
    }

}
?> 
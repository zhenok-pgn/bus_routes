<?php

class busClass {
    public $id;
    public $name;
    public $capacity;

    public function __construct($id, $name, $capacity){
        $this->id= $id;
        $this->name = $name;
        $this->capacity = $capacity;
    }

    function __destruct() {
        
    }
}

?>
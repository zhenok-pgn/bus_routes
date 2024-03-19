<?php

class busStopClass {
    public $id;
    public $name;
    public $address;

    public function __construct($id, $name, $address){
        $this->id= $id;
        $this->name = $name; 
        $this->address = $address; 
    }

    function __destruct() {
        
    }
}

?>
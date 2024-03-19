<?php

class routeClass {
    public $id;
    public $carrier;
    public $number;
    public $name;
    public $paymentMethods;
    public $busClasses;

    public function __construct($id, $carrier, $number, $name, $paymentMethods, $busClasses){
        $this->id= $id;
        $this->carrier = $carrier; 
        $this->number = $number; 
        $this->name = $name; 
        $this->paymentMethods = $paymentMethods; 
        $this->busClasses = $busClasses; 
    }

    function __destruct() {
        
    }
}

?>
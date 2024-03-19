<?php

class carrierClass {
    public $ogrn;
    public $inn;
    public $name;
    public $address;
    public $phone;
    public $email;
    public $website;

    public function __construct($ogrn, $inn, $name, $address, $phone, $email, $website){
        $this->ogrn= $ogrn;
        $this->inn = $inn; 
        $this->name = $name; 
        $this->address = $address; 
        $this->phone = $phone; 
        $this->email = $email; 
        $this->website = $website; 
    }

    function __destruct() {
        
    }
}

?>
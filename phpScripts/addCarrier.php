<?php 
    $ogrn = $_GET["ogrn"] ?? NULL;
    $name = $_GET["name"] ?? NULL;
    $inn = $_GET["inn"] ?? NULL;
    $address = $_GET["address"] ?? NULL;
    $phone = $_GET["phone"] ?? 'NULL';
    $email = $_GET["email"] ?? 'NULL';
    $website = $_GET["website"] ?? 'NULL';
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->addCarrier($ogrn, $inn, $name, $address, $phone, $email, $website);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
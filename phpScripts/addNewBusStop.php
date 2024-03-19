<?php 
    $name = $_GET["name"] ?? NULL;
    $address = $_GET["address"] ?? NULL;
    $cityCode = $_GET["city"] ?? 'NULL';
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->addBusStop($name, $address, $cityCode);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
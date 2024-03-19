<?php 
    $cityCode = $_GET["city-code"] ?? NULL;
    $name = $_GET["name"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->addCity($cityCode, $name);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
<?php 
    $city = $_GET["city-code"] ?? NULL;
    $filter = $_GET["filter"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->getRoutesByCityCodeAndName($city, $filter);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
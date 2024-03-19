<?php 
    $routeId = $_GET["route-id"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->deleteRoute($routeId);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
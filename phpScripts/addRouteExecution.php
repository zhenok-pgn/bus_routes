<?php 
    $time = $_GET["time"] ?? NULL;
    $directionId = $_GET["direction-id"] ?? NULL;
    $routeId = $_GET["route-id"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->addRouteExecution($routeId, $directionId, $time);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
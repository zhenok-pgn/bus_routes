<?php 
    $busArriving = $_GET["bus-arriving"] ?? NULL;
    $routexecId = $_GET["route-exec-id"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->updateRouteExecution($routexecId, $busArriving);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
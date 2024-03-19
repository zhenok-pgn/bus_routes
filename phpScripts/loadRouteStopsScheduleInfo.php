<?php 
    $routeExecId = $_GET["routeExecId"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->getBusStopsScheduleByRouteExec($routeExecId);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
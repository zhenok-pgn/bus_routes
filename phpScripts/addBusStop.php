<?php 
    $busArriving = $_GET["bus-arriving"] ?? NULL;
    $busStopId = $_GET["bus-stop-id"] ?? NULL;
    $routexecId = $_GET["route-exec-id"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->addBusStopsSchedule($routexecId, $busStopId, $busArriving);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
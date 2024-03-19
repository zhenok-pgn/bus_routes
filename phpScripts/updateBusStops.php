<?php 
    $busArriving = $_GET["bus-arriving"] ?? NULL;
    $busStopId = $_GET["bus-stop-id"] ?? NULL;
    $busStopExecId = $_GET["bus-stop-exec-id"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->updateBusStopsSchedule($busStopExecId, $busStopId, $busArriving);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
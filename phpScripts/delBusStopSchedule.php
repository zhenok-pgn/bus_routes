<?php 
    $busStopSchedule = $_GET["busStopSchedule"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->deleteBusStopSchedule($busStopSchedule);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
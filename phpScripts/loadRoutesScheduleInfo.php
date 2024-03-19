<?php 
    $dirId = $_GET["dirId"] ?? NULL;
    $routeId = $_GET["routeId"] ?? NULL;
    $date = $_GET["date"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->getRouteScheduleByDirectionAndDate($routeId, $dirId, $date);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
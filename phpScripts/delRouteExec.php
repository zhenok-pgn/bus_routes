<?php 
    $routexecId = $_GET["routeExecId"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->deleteRouteExecution($routexecId);                
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
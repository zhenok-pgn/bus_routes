<?php 
    $city = $_GET["city-code"] ?? NULL;
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->getBusStopsByCity($city);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
<?php 
    $cityCode = $_GET["cityCode"] ?? NULL;
    $routeNum = $_GET["routeNum"] ?? NULL;
    $routeName = $_GET["routeName"] ?? NULL;
    $carrier = $_GET["carrier"] ?? NULL;
    $busClasses = $_GET["busClasses"] ?? NULL;
    $payments = $_GET["payments"] ?? NULL;
    $prices = $_GET["prices"] ?? NULL;
    
    require_once("../classes/DBClass.php");                                
    $db = new DBClass();
    $routes = $db->addBusRoute($cityCode, $routeNum, $routeName, $carrier, $busClasses, $payments, $prices);                  
    unset($db);
    echo json_encode(["content"=>$routes]);
?>
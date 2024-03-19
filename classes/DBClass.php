<?php
require_once("busClass.php");
require_once("carrierClass.php");
require_once("paymentMethodClass.php");
require_once("routeClass.php");

class DBClass {
    private $server = "localhost";
    private $userName = "root";
    private $userPassword = "root";
    private $dbName = "citybusroutes";
    
    private $link;

    public function __construct() {
        $this->link = 
            mysqli_connect(
                $this->server, 
                $this->userName, 
                $this->userPassword,
                $this->dbName);
    }

    function __destruct() {
        mysqli_close($this->link);
    }

    function getCities(){
        $result = [];
        $query = "
            SELECT city_code, city_name 
            FROM city
            order by city_name";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[$row['city_code']] =  $row['city_name'];                               
        }
        return $result;
    }

    function getDirections(){
        $result = [];
        $query = "
            SELECT bus_direction_id, bus_direction_name 
            FROM bus_direction
            order by bus_direction_name";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[$row['bus_direction_id']] =  $row['bus_direction_name'];                               
        }
        return $result;
    }

    function getRouteScheduleByDirectionAndDate($routeId, $directionId, $date){
        $result = [];
        $query = "
            SELECT route_execution_id, route_execution_time
            FROM route_execution
            where date(route_execution_time) = date('$date') and route_id = $routeId and bus_direction_id = $directionId
            order by route_execution_time";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[$row['route_execution_id']] =  $row['route_execution_time'];                               
        }
        return $result;
    }

    function getRoutesByCityCodeAndName($cityCode, $filter){
        $result = [];
        $extraQuery = "";
        if($filter != NULL)
            $extraQuery = " and route_number like '%$filter%' or route_name like '%$filter%' ";
        $query = "
            SELECT route_id, route_number 
            FROM route
            where city_code = '$cityCode'".$extraQuery."order by route_number";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[$row['route_id']] =  $row['route_number'];                               
        }
        return $result;
    }

    function getRouteInfoById($id){
        $result = null;
        $query = "
            SELECT carrier_ogrn, route_number, route_name 
            FROM route
            where route_id = $id";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $carrier = $this->getCarrierInfoById($row['carrier_ogrn']); 
            $paymentMethods = $this->getPaymentMethodsByRouteId($id);
            $busClasses = $this->getBusClassesByRouteId($id);
            $result = new routeClass($id, $carrier, $row['route_number'], $row['route_name'], $paymentMethods, $busClasses);
        }
        return $result;
    }

    function getCarrierInfoById($id){
        $result = null;
        $query = "
            SELECT carrier_ogrn, carrier_inn, carrier_name, carrier_address, carrier_phone, carrier_email, carrier_website
            FROM carrier
            where carrier_ogrn = $id";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result =  new carrierClass(
                $row['carrier_ogrn'], $row['carrier_inn'], 
                $row['carrier_name'], $row['carrier_address'], 
                $row['carrier_phone'], $row['carrier_email'], 
                $row['carrier_website']
            );                               
        }
        return $result;
    }

    function getCarriers(){
        $result = [];
        $query = "
            SELECT carrier_ogrn, carrier_inn, carrier_name, carrier_address, carrier_phone, carrier_email, carrier_website
            FROM carrier";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] =  new carrierClass(
                $row['carrier_ogrn'], $row['carrier_inn'], 
                $row['carrier_name'], $row['carrier_address'], 
                $row['carrier_phone'], $row['carrier_email'], 
                $row['carrier_website']
            );                               
        }
        return $result;
    }

    function getPaymentMethodsByRouteId($id){
        $result = [];
        $query = "
            SELECT rp.payment_method_id, payment_method_name, price 
            FROM route_price rp left join payment_method pm 
            on rp.payment_method_id = pm.payment_method_id 
            where route_id = $id";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = new paymentMethodClass($row['payment_method_id'], $row['payment_method_name'], $row['price']);                           
        }
        return $result;
    }

    function getPaymentMethods(){
        $result = [];
        $query = "
            SELECT payment_method_id, payment_method_name 
            FROM payment_method";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = new paymentMethodClass($row['payment_method_id'], $row['payment_method_name'], null);                           
        }
        return $result;
    }

    function getBusClassesByRouteId($id){
        $result = [];
        $query = "
            SELECT bd.bus_class_id, bus_class_name, bus_class_capacity 
            FROM bus_depot bd left join bus_class bc 
            on bd.bus_class_id = bc.bus_class_id 
            where route_id = $id";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = new busClass($row['bus_class_id'], $row['bus_class_name'], $row['bus_class_capacity']);                           
        }
        return $result;
    }

    function getBusClasses(){
        $result = [];
        $query = "
            SELECT bus_class_id, bus_class_name, bus_class_capacity 
            FROM bus_class";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = new busClass($row['bus_class_id'], $row['bus_class_name'], $row['bus_class_capacity']);                           
        }
        return $result;
    }

    function getBusStopsScheduleByRouteExec($routeExecId){
        $result = [];
        $query = "
            SELECT bus_stop_schedule_id, bss.bus_stop_id, bus_stop_name, bus_stop_address, arriving_time 
            FROM bus_stop_schedule bss left join bus_stop bs
            on bss.bus_stop_id = bs.bus_stop_id
            where route_execution_id = $routeExecId
            order by arriving_time";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = ['busStopScheduleId' => $row['bus_stop_schedule_id'], 'busStopName' => $row['bus_stop_name'], 'busStopId' => $row['bus_stop_id'], 'busStopAddress' => $row['bus_stop_address'], 'arrivingTime' => $row['arriving_time']];                               
        }
        return $result;
    }

    function getBusStopsByCity($id){
        $result = [];
        $query = "
        SELECT bus_stop_id, bus_stop_name, bus_stop_address 
        FROM bus_stop
        where city_code = '$id'
        order by bus_stop_name";                
        $queryResult = mysqli_query($this->link, $query);                
        while ($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = ['busStopName' => $row['bus_stop_name'], 'busStopId' => $row['bus_stop_id'], 'busStopAddress' => $row['bus_stop_address']];                               
        }
        return $result;
    }

    function updateBusStopsSchedule($scheduleId, $busStopId, $busArriving){
        $query = "
            update bus_stop_schedule 
            set bus_stop_id = $busStopId, arriving_time = '$busArriving'
            where bus_stop_schedule_id = $scheduleId";                
        return mysqli_query($this->link, $query);                
    }

    function addBusStopsSchedule($routeExecId, $busStopId, $busArriving){
        $query = "
            insert into bus_stop_schedule (route_execution_id, bus_stop_id, arriving_time)
            values ($routeExecId, $busStopId, '$busArriving')";                
        return mysqli_query($this->link, $query);                
    }

    function updateRouteExecution($id, $time){
        $query = "
            update route_execution 
            set route_execution_time = '$time'
            where route_execution_id = $id";                
        $result = mysqli_query($this->link, $query);   
        return $result;             
    }

    function addRouteExecution($routeId, $directionId, $time){
        $query = "
            insert into route_execution (route_id, bus_direction_id, route_execution_time)
            values ($routeId, $directionId, '$time')";                
        return mysqli_query($this->link, $query);                
    }

    function deleteRouteExecution($routexecId){
        $query = "
            delete from route_execution 
            where route_execution_id = $routexecId
            ";                
        return mysqli_query($this->link, $query);                
    }

    function deleteBusStopSchedule($busStopSchedule){
        $query = "
            delete from bus_stop_schedule 
            where bus_stop_schedule_id = $busStopSchedule
            ";                
        return mysqli_query($this->link, $query);                
    }

    function deleteRoute($routeId){
        $query = "
            delete from route 
            where route_id = $routeId
            ";                
        return mysqli_query($this->link, $query);                
    }

    function updateBusRoute($routeId, $routeNum, $routeName, $carrier, $busClasses, $payments, $prices){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $mysqli = new mysqli($this->server, $this->userName, $this->userPassword, $this->dbName);
        $mysqli->begin_transaction();
        try {
            /* Добавление каких-то значений */
            $mysqli->query("DELETE FROM route_price WHERE route_id = $routeId");
            $mysqli->query("DELETE FROM bus_depot WHERE route_id = $routeId");
            for($i = 0; $i < count($payments); $i++){
                $mysqli->query("INSERT INTO route_price (route_id, payment_method_id, price) VALUES ($routeId, $payments[$i], $prices[$i])");
            }
            for($i = 0; $i < count($busClasses); $i++){
                $mysqli->query("INSERT INTO bus_depot (route_id, bus_class_id) VALUES ($routeId, $busClasses[$i])");
            }
            $mysqli->query("UPDATE route set carrier_ogrn = $carrier, route_number = '$routeNum', route_name = '$routeName' WHERE route_id = $routeId");

            /* Если код достигает этой точки без ошибок, фиксируем данные в базе данных. */
            $mysqli->commit();
            return true;
        } catch (mysqli_sql_exception $exception) {
            $mysqli->rollback();

            return false;
        }               
    }

    function addBusRoute($cityCode, $routeNum, $routeName, $carrier, $busClasses, $payments, $prices){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($this->server, $this->userName, $this->userPassword, $this->dbName);
        
        $mysqli->begin_transaction();
        try {
            /* Добавление каких-то значений */
            $mysqli->query("INSERT into route (carrier_ogrn, route_number, route_name, city_code) VALUES ($carrier, '$routeNum', '$routeName', $cityCode)");

            $queryResult =  $mysqli->query("SELECT route_id from route where route_name='$routeName' and route_number='$routeNum'");
            $id = null;
             while ($row = $queryResult->fetch_assoc())
                $id = $row['route_id'];

            for($i = 0; $i < count($payments); $i++){
                $mysqli->query("INSERT INTO route_price (route_id, payment_method_id, price) VALUES ($id, $payments[$i], $prices[$i])");
            }
            for($i = 0; $i < count($busClasses); $i++){
                $mysqli->query("INSERT INTO bus_depot (route_id, bus_class_id) VALUES ($id, $busClasses[$i])");
            }

            /* Если код достигает этой точки без ошибок, фиксируем данные в базе данных. */
            $mysqli->commit();
            return true;
        } catch (mysqli_sql_exception $exception) {
            $mysqli->rollback();
            return false;
        }               
    }

    function addCity($cityCode, $name){
        $query = "
            insert into city (city_code, city_name)
            values ('$cityCode', '$name')";                
        return mysqli_query($this->link, $query);                
    }

    function addCarrier($ogrn, $inn, $name, $address, $phone, $email, $website){
        $query = "
            insert into carrier (carrier_ogrn, carrier_inn, carrier_name, carrier_address, carrier_phone, carrier_email, carrier_website)
            values ('$ogrn', '$inn', '$name', '$address', '$phone', '$email', '$website')";                
        return mysqli_query($this->link, $query);                
    }

    function addBusStop($name, $address, $cityCode){
        $query = "
            insert into bus_stop (bus_stop_name, bus_stop_address, city_code)
            values ('$name', '$address', '$cityCode')";                
        return mysqli_query($this->link, $query);                
    }
}
?>
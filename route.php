<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style/style.css" />
  </head>
  <body>
    <?php
    $route = $_GET["route-id"] ?? NULL;
    require_once('header.php');
    ?>
    
    <section class="mb-5">    
        <div class="container pt-4">
            <?php
            if($route == NULL)
                echo("Ошибка. Маршрут не найден");
            else{
                require_once("classes/DBClass.php");
                $db = new DBClass();  
                $routeInfo = $db->getRouteInfoById($route);
                unset($db);
            ?>
            <p class="fs-3 mb-4">Маршрут <?php echo("{$routeInfo->number} ({$routeInfo->name})"); ?></p>
            <div class="line"></div>
            <p>Перевозчик:</p>
            <a href="#"><?php echo($routeInfo->carrier->name); ?></a>
            <p>Классы автобусов:</p>
            <?php
                for($i = 0; $i < count($routeInfo->busClasses); $i++) {
            ?>
                    <p><?php echo("{$routeInfo->busClasses[$i]->name}: {$routeInfo->busClasses[$i]->capacity} чел."); ?></p>
            <?php
                }
            ?>
            <p>Типы оплаты и стоимость проезда:</p>
            <?php
                for($i = 0; $i < count($routeInfo->paymentMethods); $i++) {
            ?>
                    <p><?php echo("{$routeInfo->paymentMethods[$i]->name}: {$routeInfo->paymentMethods[$i]->price} руб."); ?></p>
            <?php
                }
            ?>
            <?php } ?>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditRoute">Изменить</button>
            <button type="button" class="delete-route-btn btn btn-primary">Удалить маршрут</button>
            <div class="line"></div>
            <div class="row">
              <div class="col">
                  <label for="start">Дата:</label>
                  <input type="date" id="date-view"/>
              </div>
              <div class="col">
                <div class="row">
                  <label for="start" class="col">Направление:</label>
                  <select class="select-direction form-select col" name="direction">
                    <option selected disabled>Направление</option>  
                    <?php
                      require_once("classes/DBClass.php");                               
                      $db = new DBClass();  
                      $result = $db->getDirections();
                      unset($db);
                      foreach($result as $key => $value) {
                          $option = "<option value=".$key.">".$value."</option>";                 
                        echo $option;
                      } 
                  ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="start-time row row-cols-1 row-cols-sm-4 row-cols-md-6"></div>
            <div class="line"></div>
            <div class="bus-stops-time"></div>

            <div class="modal fade" id="modalEditBusStop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Остановка:</label>
                        <select name="" class="select-bus-stop"></select>
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Дата и время прибытия:</label>
                        <input type="datetime-local" class="date-bus-arriving"/>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="save-btn btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
                  </div>
                </div>
              </div>
          </div>

          <div class="modal fade" id="modalEditRouteStart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Дата и время:</label>
                        <input type="datetime-local" class="time-start-route"/>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="save-route-btn btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
                  </div>
                </div>
              </div>
          </div>

          <?php
            $db = new DBClass();  
            $carriers = $db->getCarriers();
            $busClasses = $db->getBusClasses();
            $paymentMethods = $db->getPaymentMethods();
            unset($db);
          ?>
          <div class="modal fade" id="modalEditRoute" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Изменить маршрут</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Номер маршрута:</label>
                        <input type="text" class="route-number-modal" value="<?php echo $routeInfo->number; ?>"/>
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Название маршрута:</label>
                        <input type="text" class="route-name-modal" value="<?php echo $routeInfo->name; ?>"/>
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Перевозчик:</label>
                        <select class="carrier-select" style="width: 300px;">
                            <?php
                              for($j = 0; $j < count($carriers); $j++) {
                            ?>
                            <option <?php if($carriers[$j]->ogrn == $routeInfo->carrier->ogrn) echo 'selected'; ?> value="<?php echo $carriers[$j]->ogrn; ?>">
                              <?php echo("{$carriers[$j]->name} (ОГРН: {$carriers[$j]->ogrn})"); ?>
                            </option>
                            <?php
                              }
                            ?>
                          </select>
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Классы автобусов</label>
                        <div class="bus-classes-block">
                          <?php
                            for($i = 0; $i < count($routeInfo->busClasses); $i++) {
                          ?>
                            <select class="data-busclassid-<?php echo $i; ?>">
                              <?php
                                for($j = 0; $j < count($busClasses); $j++) {
                              ?>
                              <option <?php if($busClasses[$j]->id == $routeInfo->busClasses[$i]->id) echo 'selected'; ?> value="<?php echo $busClasses[$j]->id; ?>">
                                <?php echo("{$busClasses[$j]->name} ({$busClasses[$j]->capacity} чел.)"); ?>
                              </option>
                              <?php
                                }
                              ?>
                            </select>
                            <input type="button" class="del-busclass-btn" data-busclassid="<?php echo $i; ?>" value="X">
                        
                        <?php
                          }
                        ?>
                        </div>
                        <button data-busclassId="<?php echo count($routeInfo->busClasses); ?>" type="button" class="add-busclass-btn btn btn-primary">Добавить</button>
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Типы и стоимость оплаты проезда:</label>
                        <div class="payment-block">
                          <?php
                            for($i = 0; $i < count($routeInfo->paymentMethods); $i++) {
                          ?>
                            <select class="data-paymentid-<?php echo $i; ?>">
                              <?php
                                for($j = 0; $j < count($paymentMethods); $j++) {
                              ?>
                              <option <?php if($paymentMethods[$j]->id == $routeInfo->paymentMethods[$i]->id) echo 'selected'; ?> value="<?php echo $paymentMethods[$j]->id; ?>">
                                <?php echo("{$paymentMethods[$j]->name}"); ?>
                              </option>
                              <?php
                                }
                              ?>
                            </select>
                            <input class="data-paymentid-<?php echo $i; ?>" type="number" name="tentacles" min="0" max="10000" value="<?php echo $routeInfo->paymentMethods[$i]->price; ?>"/>
                            <input type="button" class="del-payment-btn" data-paymentid="<?php echo $i; ?>" value="X">
                          <?php
                            }
                          ?>
                        </div>
                        <button data-paymentId="<?php echo count($routeInfo->paymentMethods); ?>" type="button" class="add-payment-btn btn btn-primary">Добавить</button>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="save-route-params-btn btn btn-primary" data-bs-dismiss="modal" data-isadd="0">Изменить</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="js/loadRouteScheduleInfo.js"></script>
    <script src="js/editRouteModal.js"></script>
  </body>
</html>

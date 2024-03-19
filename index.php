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
    $city = $_GET["city-code"] ?? NULL;
    if($city != NULL)
      setcookie('city-code', $city, 0, '/');

    require_once('header.php');
    ?>
    
    <section class="car-filter mb-5">    
        <div class="container pt-4" id="myTabContent">
          <p class="fs-3 mb-4">Городские маршруты</p>
          <div class="line"></div>
          <div class="routes-table">
            <input type="text" class="form-control" placeholder="Фильтр по номеру или названию маршрута">
          </div>
          <div class="routes row row-cols-1 row-cols-sm-4 row-cols-md-6"></div>
        </div>


        <?php
            require_once("classes/DBClass.php");
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
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Добавление маршрута</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Номер маршрута:</label>
                      <input type="text" class="route-number-modal" value=""/>
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Название маршрута:</label>
                      <input type="text" class="route-name-modal" value=""/>
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Перевозчик:</label>
                      <select class="carrier-select" style="width: 300px;">
                          <?php
                            for($j = 0; $j < count($carriers); $j++) {
                          ?>
                          <option value="<?php echo $carriers[$j]->ogrn; ?>">
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
                          <select class="data-busclassid-0">
                            <?php
                              for($j = 0; $j < count($busClasses); $j++) {
                            ?>
                            <option value="<?php echo $busClasses[$j]->id; ?>">
                              <?php echo("{$busClasses[$j]->name} ({$busClasses[$j]->capacity} чел.)"); ?>
                            </option>
                            <?php
                              }
                            ?>
                          </select>
                          <input type="button" class="del-busclass-btn" data-busclassid="0" value="X">
                      </div>
                      <button data-busclassId="1" type="button" class="add-busclass-btn btn btn-primary">Добавить</button>
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Типы и стоимость оплаты проезда:</label>
                      <div class="payment-block">
                          <select class="data-paymentid-0">
                            <?php
                              for($j = 0; $j < count($paymentMethods); $j++) {
                            ?>
                            <option value="<?php echo $paymentMethods[$j]->id; ?>">
                              <?php echo("{$paymentMethods[$j]->name}"); ?>
                            </option>
                            <?php
                              }
                            ?>
                          </select>
                          <input class="data-paymentid-0" type="number" name="tentacles" min="0" max="10000" value=""/>
                          <input type="button" class="del-payment-btn" data-paymentid="0" value="X">
                      </div>
                      <button data-paymentId="1" type="button" class="add-payment-btn btn btn-primary">Добавить</button>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                  <button type="button" class="save-route-params-btn btn btn-primary" data-bs-dismiss="modal" data-isadd="1">Добавить</button>
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
    <script src="js/loadCityRoutes.js"></script>
    <script src="js/editRouteModal.js"></script>
  </body>
</html>

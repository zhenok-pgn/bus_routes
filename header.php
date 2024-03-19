<header class="p-3 text-bg-white shadow-sm">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a
            href="index.php"
            class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
          >
            <svg class="bi me-2" width="100" height="45" role="img">
              <use xlink:href="#bootstrap" />
              <image
                xlink:href="image/Logo_NN_Bus.svg"
                x="0"
                y="0"
                height="45px"
                width="100px"
              />
            </svg>
          </a>

          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="addCarrier.php" class="nav-link px-3 text-secondary-emphasis">Добавить перевозчика</a></li>
            <li><a href="addCity.php" class="nav-link px-3 text-secondary-emphasis">Добавить город</a></li>
            <li><a href="addNewBusStop.php" class="nav-link px-3 text-secondary-emphasis">Добавить остановку</a></li>
          </ul>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-1" role="search" action="index.php" method="get">
            <div class="row">
              <select class="form-select col mx-1" aria-label="Пример выбора по умолчанию" name="city-code">
                <?php
                  require_once("classes/DBClass.php");
                  $cityCodeFromCookie = $_COOKIE['city-code'] ?? NULL;
                ?>
                  <option <?php if($cityCodeFromCookie == NULL) echo('selected'); ?> disabled>Города</option>
                <?php                                  
                  $db = new DBClass();  
                  $cities = $db->getCities();
                  unset($db);
                  foreach($cities as $key => $value) {
                    if($cityCodeFromCookie == $key)
                      $option = "<option selected value=".$key.">".$value."</option>";
                    else
                      $option = "<option value=".$key.">".$value."</option>";                 
                    echo $option;
                  } 
                ?>
              </select>
              <input type="submit" class="col btn btn-secondary" value="Найти">
            </div>
          </form>
        </div>
      </div>
    </header>
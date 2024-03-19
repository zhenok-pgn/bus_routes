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
    require_once('header.php');
    ?>
    
    <section class="car-filter mb-5">    
        <div class="container pt-4" id="myTabContent">
            <p class="fs-3 mb-4">Добавление перевозчика</p>
            <input type="text" class="ogrn form-control" placeholder="Введите ОГРН">
            <input type="text" class="inn form-control" placeholder="Введите ИНН">
            <input type="text" class="name form-control" placeholder="Введите название огранизации">
            <input type="text" class="address form-control" placeholder="Введите юридический адрес">
            <input type="text" class="phone form-control" placeholder="Введите номер телефона (необязательное поле)">
            <input type="text" class="email form-control" placeholder="Введите электронную почту (необязательное поле)">
            <input type="text" class="website form-control" placeholder="Введите веб-сайт (необязательное поле)">
            <input type="button" class="add-carrier btn btn-primary" value="Добавить">
        </div>
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="js/addCarrier.js"></script>
  </body>
</html>

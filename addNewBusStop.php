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
            <p class="fs-3 mb-4">Добавление остановочного пункта</p>
            <input type="text" class="name form-control" placeholder="Введите название остановки">
            <input type="text" class="address form-control" placeholder="Введите адрес">
            <input type="button" class="add-new-bus-stop btn btn-primary" value="Добавить">
        </div>
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="js/addBusStop.js"></script>
  </body>
</html>
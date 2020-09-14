<?php
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas
session_start(); // Poder acceder a $_SESSION

if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
};


?>
<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Referencing CSS files -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/estilos.css" type="text/css">

  <style>
    .container {
      max-width: 960px;
    }

    .lh-condensed {
      line-height: 1.25;
    }
  </style>

  <title>Pedir - Farma Paysandú</title>

</head>

<body class="bg-light">

  <!-- VOLVER 2 Y PEDIR-->
  <br>
  <div class="pl-5">
    <button id="btnVolver2" class="btn btn-link">Cancelar</button>
  </div>
  <!-- END VOLVER -->


  <!-- ENVIAR PEDIDO -->
  <div id="MenuPedir" class="container rounded-lg">
    <br>
    <div class="row">

      <!-- FORMULARIO -->
      <div class="col-7 px-5">
        <h4 class="mb-3">Datos a enviar</h4>

        <form method="POST" action="enviarPedido.php">
          <div class="form-group">
            <label for="confContrasena">Confirmar Contraseña</label>
            <input name="inConfContrasena" type="password" class="form-control">
          </div>
          <div class="form-group">
            <label for="inputAddress">Dirección</label>
            <input readonly name="inDireccion" type="text" class="form-control" id="inDireccion" value="<?php echo $_SESSION['userDir'] ?>">
          </div>
          <hr class="mb-4">
          <div class="justify-content-end">
            <button id="btnPedir" class="btn btn-danger btn-lg btn-block" type="submit">Ordenar a mi Casa!</button>
          </div>
        </form>
      </div>
      <!-- FIN FORMULARIO -->

      <!-- CARRITO -->
      <div class="col-5 pt-2 px-0">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Carrito</span>
          <span class="badge badge-secondary badge-pill"><?php echo count($_SESSION['farmacos']) ?></span>
        </h4>

        <div id="cartList" class="list-group mb-3">
          <!-- ITEM CARRITO -->
          <?php foreach ($_SESSION['farmacos'] as $item) : ?>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0"><?php echo $item['nombreFarmaco'] ?></h6>
                <small class="text-muted"><?php echo $item['nombreFarmacia'] ?></small>
              </div>
              <div>
                <span class="badge badge-primary badge-pill"><?php echo $item['many'] ?></span>
                <span class="px-2">x</span>
                <span class="text-muted">$<?php echo $item['precioUnitario'] ?></span>
              </div>
            </a>

          <?php endforeach ?>
          <!-- TOTAL CARRITO -->
          <a href="#" class="list-group-item list-group-item-action list-group-item-dark d-flex justify-content-between">
            <span>Total (URU)</span>
            <strong>$
              <?php 
              $prices = 0;
              // $prices = array_column($_SESSION['farmacos'], 'precioUnitario');
              foreach ($_SESSION['farmacos'] as $farmaco) {
                  //print_r($farmaco);
                $prices += $farmaco['precioUnitario'] * $farmaco['many'];
              };
              // $total = 0;
              // foreach ($prices as $price) {
              //   $total += $price; //FALTA MULTIPLICAR POR LA CANTIDAD
              // }
              echo $prices;
              ?>
            </strong>
          </a>
        </div>
      </div>
      <!-- FIN CARRITO -->
    </div>
  </div>
  <!-- FIN ENVIAR PEDIDO -->


  <!-- Referencing JS from Bootstrap workflow -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="js/bootstrap.min.js"></script>
  <!-- Referencing JS for Non-Images work -->
  <script src="js/holder.js"></script>
  <!-- Referencing JS from HERE API, for Maps Services -->
  <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/calculate.js"></script>


  <script>
    $('#cartList a').on("click", function(e) {
      e.preventDefault()
    })
  </script>
</body>

</html>
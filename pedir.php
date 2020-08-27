<?php session_start(); // Poder acceder a $_SESSION
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}
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

  <!-- Referencing Fontawesome Icons (THIS MUST GO IN THE 'HEAD' TAG) -->
  <script src="https://kit.fontawesome.com/24904b643a.js" crossorigin="anonymous"></script>

  <title>Pedir - Farma Paysandú</title>

</head>

<body style="background-color: #ECEDEF;">
  <?php if (!isset($_SESSION['user'])) : ?>
    <!-- ENVIAR PEDIDO -->
    <div id="MenuPedir" class="container" style="display: none;">
      <br>
      <form method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Confirmar Cédula</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="12345678">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Contraseña</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="*********">
          </div>
        </div>
        <div class="form-group">
          <label for="inputAddress">Dirección</label>
          <input disabled type="text" class="form-control" id="inDireccion">
        </div>
      </form>

      <!-- VOLVER 2 Y PEDIR-->
      <br>
      <div class="row justify-content-between">
        <button id="btnVolver2" class="btn btn-link">Volver</button>
        <div class="justify-content-end">
          <button id="btnPedir" class="btn btn-danger" type="submit">Pedir!</button>
        </div>
      </div>
      <br>
      <!--  -->
    </div>
    <!--  -->

  <?php endif ?>
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
</body>

</html>
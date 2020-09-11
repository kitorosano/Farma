<?php
include_once '../includes/conexion.php'; //al inicio para verificar los usuarios existentes

if ($_POST) {

  //CAPTURAR DATOS POR POST//
  $usuario_nuevo = $_POST['ciUser'];
  $nombre = $_POST['nameUser'];
  $contrasena = $_POST['passUser'];
  $contrasena2 = $_POST['passUser2'];

  //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
  $sql = 'SELECT * FROM usuarios WHERE ciUsuario=?';
  $consul_verify = $pdo->prepare($sql);
  $consul_verify->execute(array($usuario_nuevo));
  $result = $consul_verify->fetch();

  // var_dump($result);
  if ($result) {
    echo '<br>Usuario ya existente';
    die();
  }


  //HASH DE LA CONTRASEÑA1//
  $options = [
    'cost' => 9, //segun las capacidades del server
  ];
  $contrasena = password_hash($contrasena, PASSWORD_BCRYPT, $options);

  echo '<pre>';
  // var_dump($usuario_nuevo);
  // var_dump($contrasena);
  // var_dump($contrasena2);
  // echo '</pre>';

  //VERIFICACION DE CONTRASEÑA//
  if (password_verify($contrasena2, $contrasena)) {
    echo 'Password is valid! <br>';

    //AGREGAR A LA BASE DE DATOS//

    $sql_agregar = 'INSERT INTO usuarios (ciUsuario,nombreUsuario,contrasenaUsuario) VALUES (?,?,?)';
    $consul_agregar = $pdo->prepare($sql_agregar);

    if ($consul_agregar->execute(array($usuario_nuevo, $nombre, $contrasena))) {
      echo '<br>Agregrado';
    } else {
      echo '<br>Error agregando';
    }

    //CERRAMOS CONEXION CON LA BASE DE DATOS Y LA CONSULTA//
    $consul_agregar = null;
    $pdo = null;
    header('location: .');
  } else {
    echo 'Invalid password.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>


  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

  <div class="container">
    <h3>Registro de Usuario</h3>

    <form class="d-flex flex-column" method="POST">
      <input class="form-control m-1" type="text" name="ciUser" placeholder="Ingresa Documento">
      <input class="form-control m-1" type="text" name="nameUser" placeholder="Ingresa Nombre">
      <input class="form-control m-1" type="password" name="passUser" placeholder="Ingresa Contraseña">
      <input class="form-control m-1" type="password" name="passUser2" placeholder="Ingresa nuevamente la contraseña">
      <button class="btn btn-primary m-2" type="submit">Guardar</button>
    </form>
  </div>


  <!-- Referencing JS from Bootstrap workflow -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
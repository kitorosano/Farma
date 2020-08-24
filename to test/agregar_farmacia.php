<?php
include_once '../conexion.php'; //conectarse a la Base de Datos

//CAPTURAR DATOS POR POST//
$farmacia_nueva = $_POST['codFarma'];
$nombre = $_POST['nameFarma'];
$contrasena = $_POST['passFarma'];
$contrasena2 = $_POST['passFarma2'];
$localidad = $_POST['localFarma'];
$telefono = $_POST['telFarma'];

//VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM farmacias WHERE codFarmacia=?';
$consul_verify = $pdo->prepare($sql);
$consul_verify->execute(array($farmacia_nueva));
$result = $consul_verify->fetch();

// var_dump($result);
if ($result) {
  echo '<br>Farmacia ya existente';
  die();
}


//HASH DE LA CONTRASEÑA1//
$options = [
  'cost' => 9, //segun las capacidades del server
];
$contrasena = password_hash($contrasena, PASSWORD_BCRYPT, $options);

echo '<pre>';
// var_dump($farmacia_nueva);
// var_dump($contrasena);
// var_dump($contrasena2);
// echo '</pre>';

//VERIFICACION DE CONTRASEÑA//
if (password_verify($contrasena2, $contrasena)) {
  echo 'Contraseña Valida! <br>';

  //AGREGAR A LA BASE DE DATOS//

  $sql_agregar = 'INSERT INTO farmacias (codFarmacia,nombreFarmacia,contrasenaFarmacia,localidad,telefono) VALUES (?,?,?,?,?)';
  $consul_agregar = $pdo->prepare($sql_agregar);

  if ($consul_agregar->execute(array($farmacia_nueva, $nombre, $contrasena, $localidad, $telefono))) {
    echo '<br>Agregrado';
  } else {
    echo '<br>Error al agregar';
  }

  //CERRAMOS CONEXION CON LA BASE DE DATOS Y LA CONSULTA//
  $consul_agregar = null;
  $pdo = null;
  header('location:farmacias.php');
} else {
  echo 'Invalid password.';
}

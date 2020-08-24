<?php
include_once '../Farma/conexion.php'; //al inicio para verificar los usuarios existentes

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
  header('location:index.php');
} else {
  echo 'Invalid password.';
}

<?php
include_once 'includes/conexion.php';
session_start();
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}


$userCi = $_POST['ciUser'];
$userPass = $_POST['passUser'];

// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM usuarios WHERE ciUsuario=?';
$consul_verifyuser = $pdo->prepare($sql);
$consul_verifyuser->execute(array($userCi));
$result = $consul_verifyuser->fetch();

if (!$result) { //verificar result
  echo '<br>No existe el usuario para iniciar la sesion';
  die();
}
if (password_verify($userPass, $result['contrasenaUsuario'])) {
  $_SESSION['user'] = $userCi;

  header('Location: .'); //REDIRECCIONA LA PAGINA A SI MISMA
} else {
  echo 'Password is not valid!';
}

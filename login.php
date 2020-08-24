<?php
session_start();
include_once 'conexion.php';


$userCi = $_POST['ciUser'];
// $userName = $_POST['username'];
$userPass = $_POST['passUser'];

// echo '<pre>';
// var_dump($userCi, $userPass);
// echo '</pre>';


// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM usuarios WHERE ciUsuario=?';
$consul_verifyuser = $pdo->prepare($sql);
$consul_verifyuser->execute(array($userCi));
$result = $consul_verifyuser->fetch();

// echo '<pre>';
// var_dump($result);
// echo '</pre>'; 

if (!$result) { //verificar result
  echo '<br>No existe el usuario para iniciar la sesion';
  die();
}
if (password_verify($userPass, $result['contrasenaUsuario'])) {
  $_SESSION['user'] = $userCi;


  header('Location: .'); //REDIRECCIONA LA PAGINA A SI MISMA
  // header('Refresh: 0');
} else {
  echo 'Password is not valid!';
}
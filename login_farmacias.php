<?php
include_once 'includes/conexion.php';
session_start();


$farmaCode = $_POST['codFarma'];
// $userName = $_POST['nameFarma'];
$farmaPass = $_POST['passFarma'];

// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM farmacias WHERE codfarmacia=?';
$consul_verifyuser = $pdo->prepare($sql);
$consul_verifyuser->execute(array($farmaCode));
$result = $consul_verifyuser->fetch();

// echo '<pre>';
// var_dump($result);
// echo '</pre>'; 

if (!$result) { //verificar result
  echo '<br>No existe la farmacia para iniciar la sesion';
  die();
}
if (password_verify($farmaPass, $result['contrasenafarmacia'])) {
  $_SESSION['farma'] = $farmaCode;

  header('Location: farmacias.php'); //REDIRECCIONA LA PAGINA A SI MISMA
  // header('Refresh: 0');
} else {
  header('Location: farmacias.php');
}

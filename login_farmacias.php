<?php
session_start();
include_once 'includes/conexion.php';


$farmaCode = $_POST['codFarma'];
// $userName = $_POST['nameFarma'];
$farmaPass = $_POST['passFarma'];

// echo '<pre>';
// var_dump($farmaCode, $farmaPass);
// echo '</pre>';


// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM farmacias WHERE codFarmacia=?';
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
if (password_verify($farmaPass, $result['contrasenaFarmacia'])) {
  $_SESSION['farma'] = $farmaCode;


  header('Location: farmacias.php'); //REDIRECCIONA LA PAGINA A SI MISMA
  // header('Refresh: 0');
} else {
  echo 'Password is not valid!';
}

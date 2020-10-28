<?php
include_once 'includes/conexion.php';
session_start();


$farmaCode = $_POST['codFarma'];
$farmaPass = $_POST['passFarma'];

// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM farmacias WHERE codfarmacia=?';
$consul_verifyuser = $pdo->prepare($sql);
$consul_verifyuser->execute(array($farmaCode));
$result = $consul_verifyuser->fetch();

if (!$result) { //verificar result
  echo json_encode('No existe la farmacia para iniciar la sesion');
}
if (password_verify($farmaPass, $result['contrasenafarmacia'])) {
  $_SESSION['farma'] = $farmaCode;
  echo json_encode("login");
} else {
  echo json_encode('Contraseña incorrecta!');
}

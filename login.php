<?php
include_once 'includes/conexion.php';
session_start();

$userCi = $_POST['ciUser'];
$userPass = $_POST['passUser'];

// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM usuarios WHERE ciusuario=?';
$consul_verifyuser = $pdo->prepare($sql);
$consul_verifyuser->execute(array($userCi));
$result = $consul_verifyuser->fetch();

if (!$result) { //verificar result echo json_encode('error');
  echo json_encode('No existe el usuario para iniciar la sesion');
} else if (password_verify($userPass, $result['contrasenausuario'])) {
  $_SESSION['user'] = $userCi;
} else {
  echo json_encode('Contraseña incorrecta!');
}

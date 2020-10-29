<?php
include_once 'includes/conexion.php';
session_start();

$userCi = $_POST['ciUser'];
$userPass = $_POST['passUser'];

// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$consul_verifyuser = $pdo->prepare('SELECT * FROM usuarios WHERE ciusuario=?');
$consul_verifyuser->execute(array($userCi));
$result = $consul_verifyuser->fetch();

print_r($userCi, $userPass);
print_r($result);

if (!$result) { //verificar result echo json_encode('error');
  $msg = 'No existe el usuario para iniciar la sesion';
  echo ($msg);
} elseif (password_verify($userPass, $result['contrasenausuario'])) {
  $_SESSION['user'] = $userCi;
  $msg = 'login';
  echo ($msg);
} else {  
  $msg = 'Contraseña incorrecta!';
  echo ($msg);
};
<?php
include_once 'includes/conexion.php';
session_start();

$userCi = $_POST['ciUser'];
$userPass = $_POST['passUser'];

// //VERIFICAR SI YA EXISTE EL USUARIO NUEVO EN LA BD//
$sql = 'SELECT * FROM usuarios WHERE ciUsuario=?';
$consul_verifyuser = $pdo->prepare($sql);
$consul_verifyuser->execute(array($userCi));
$result = $consul_verifyuser->fetch();

echo "<pr>";
print_r($result);
echo "</pr>";


if (!$result) { //verificar result
  echo '<br>No existe el usuario para iniciar la sesion';
  die();
}
var_dump(password_verify($userPass, $result['contrasenaUsuario']));
if (password_verify($userPass, $result['contrasenaUsuario'])) {
  $_SESSION['user'] = $userCi;
} else {
  echo 'Password is not valid!';
  die();
}

// header('Location: .'); //REDIRECCIONA LA PAGINA A SI MISMA
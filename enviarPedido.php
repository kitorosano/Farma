<?php
include_once 'includes/conexion.php';
session_start();
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$date = date("Y/m/d H:i:s");

$whichFarmas = (array_unique(array_column($_SESSION["farmacos"], 'idFarmacia'), SORT_NUMERIC));
for ($i = 0; $i < count($whichFarmas); $i++) {
  $pedido = [$_SESSION['user'], intval($whichFarmas[$i]), $date, $_SESSION['userDir']];

  $consul_sendPedido = $pdo->prepare("INSERT INTO pedidos (ciUsuario,idFarmacia,fecha,direccion) VALUES (?,?,?,?)");
  $consul_sendPedido->execute(array($pedido[0], $pedido[1], $pedido[2], $pedido[3]));

  $lastInsert = $pdo->lastInsertId(); //Obtener el ultimo id agregado (idFarmacia)

  $consul_sendPedido->closeCursor(); //Para poder ejecutar la sig sentencia sin errores

  foreach ($_SESSION['farmacos'] as $elt) {
    $consul_sendDetPedido = $pdo->prepare("INSERT INTO detallepedidos (idPedido,idFarmaco,cantidad,precio) VALUES (?,?,?,?)");
    $consul_sendDetPedido->execute(array($lastInsert, $elt['idFarmaco'], $elt['many'], $elt["precioUnitario"]));
  }
};

header("location: logout.php");

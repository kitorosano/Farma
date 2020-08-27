<?php
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas
session_start(); // Poder acceder a $_SESSION
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}

//OBTENER DATOS DEL CLIENTE CON SUS FARMACOS RECETADOS 
$consulUserFarmacos = $pdo->prepare("SELECT *
FROM usuarios,farmacousuarios,farmacos
WHERE farmacousuarios.ciUsuario=usuarios.ciUsuario AND farmacousuarios.codFarmaco=farmacos.codFarmaco
AND usuarios.ciUsuario=?");
$consulUserFarmacos->execute(array($_SESSION['user']));
$client = $consulUserFarmacos->fetchAll();

//VARIABLES DEL FORM
$direccion = $_POST['inAddress'];
$count = $_POST['count'];
$cart = []; //Only the farmaco
$cartMany = []; //Farmaco and How much of it
$params = [];

// PARA CADA FARMACO SELECCIONADO, PUSHEAR AL CARRITO EL CODIGO DEL FARMACO Y LA CANTIDAD A PEDIR
for ($i = 1; $i < $count; $i++) {
  if (!$_POST['inAñadir-' . $i] == 0) {

    array_push($cart, $client[$i - 1]['codFarmaco']);
    array_push($cartMany, [
      "where" => $client[$i - 1]['codFarmaco'],
      "many" => $_POST['inAñadir-' . $i]
    ]);
  }
}


foreach ($cart as $item) {
  array_push($params, $item);
};
$place_holders = implode(',', array_fill(0, count($params), '?')); //PERMITE SUSTITUIR EN EL OPERADOR IN DE LA CONSULTA

// echo "<pre>";
// var_dump($cart);
// echo "</pre>";
// echo "<br>";
// echo json_encode($params);

// BUSCAR PRIMERO EN COMEPA
$consul_knowFarma = $pdo->prepare("SELECT farmacos.codFarmaco
  FROM farmacias,farmacofarmacias,farmacos 
  WHERE farmacofarmacias.codFarmacia=farmacias.codFarmacia AND farmacofarmacias.codFarmaco=farmacos.codFarmaco 
  AND farmacias.codFarmacia = 1224 AND farmacos.codFarmaco in ($place_holders)");
$consul_knowFarma->execute($params);
$resultKnowFarma = $consul_knowFarma->fetchAll();

$results = [];
foreach ($resultKnowFarma as $r) {
  array_push($results, $r[0]);
};

if (array_diff($cart, $results) == []) {
  echo "all in comepa";

  header('Location: pedir.php');
} else {
  echo "falta algo";
}


echo "<pre>";
$diff = array_diff($cart, $results);
print_r($diff);
echo "</pre>";

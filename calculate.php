<?php
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas
session_start(); // Poder acceder a $_SESSION
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}

//OBTENER DATOS DEL CLIENTE CON SUS FARMACOS RECETADOS 
$consulUserFarmacos = $pdo->prepare("SELECT *
FROM usuarios,farmacousuarios,farmacos
WHERE farmacousuarios.idUsuario=usuarios.idUsuario AND farmacousuarios.idFarmaco=farmacos.idFarmaco
AND usuarios.ciUsuario=?");
$consulUserFarmacos->execute(array($_SESSION['user']));
$client = $consulUserFarmacos->fetchAll();


//VARIABLES DEL FORM
$direccion = $_POST['inAddress'];
$count = $_POST['count'];
$cart = []; //solo id de farmaco
$cartMany = []; //id del farmaco y cuanto se selecciono
$params = [];

// PARA CADA FARMACO SELECCIONADO, PUSHEAR AL CARRITO EL CODIGO DEL FARMACO Y LA CANTIDAD A PEDIR
for ($i = 1; $i < $count; $i++) {
  if (!$_POST['inAñadir-' . $i] == 0) {

    array_push($cart, $client[$i - 1]['idFarmaco']);
    array_push($cartMany, [
      "which" => $client[$i - 1]['idFarmaco'],
      "many" => $_POST['inAñadir-' . $i]
    ]);
  }
}
foreach ($cart as $item) {
  array_push($params, $item);
};
$place_holders = implode(',', array_fill(0, count($params), '?')); //PERMITE SUSTITUIR EN EL OPERADOR IN DE LA CONSULTA


// BUSCAR PRIMERO EN COMEPA
$consul_knowFarma = $pdo->prepare("SELECT farmacias.idFarmacia,farmacias.nombreFarmacia,farmacos.*
  FROM farmacias,farmacofarmacias,farmacos 
  WHERE farmacofarmacias.idFarmacia=farmacias.idFarmacia AND farmacofarmacias.idFarmaco=farmacos.idFarmaco 
  AND farmacias.idFarmacia = 1 AND farmacos.idFarmaco in ($place_holders)");
$consul_knowFarma->execute($params);
$resultKnowFarma = $consul_knowFarma->fetchAll();

$results = [];
foreach ($resultKnowFarma as $r) {
  array_push($results, $r['idFarmaco']);
};

if (array_diff($cart, $results) == []) { //SI TODO ESTA EN COMEPA LO HACEMOS MAS FACIL :v
  echo "all in comepa";

  for ($i = 0; $i < count($results); $i++) {
    $resultKnowFarma[$i]["many"] = $cartMany[$i]["many"];
  }
  $_SESSION['userDir'] = $direccion;
  // $_SESSION['userCart'] = $cartMany;
  $_SESSION['farmacos'] = $resultKnowFarma;
  $_SESSION['local'] = 1;
  header('Location: pedir.php');
} else { //SI NO TODO ESTA EN COMEPA, REBUSCAR EN OTRAS FARMACIAS

  echo "falta algo";
}


// echo "<pre>";
// $diff = array_diff($cart, $results);
// echo "DIFERENCIA:\n";
// var_dump($diff);
// echo "\CARRITO:\n";
// var_dump($cartMany);
// echo "\nRESULTS (CARRITO SIN MANY):\n";
// var_dump($results);
// echo "\nCONSULTA:\n";
// var_dump($resultKnowFarma);
// echo "</pre>";

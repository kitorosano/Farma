<!-- 
  OBTENER - PRECIO, FARMACIA, CUANTOS, NOMBRE - DE LOS FARMACOS, Y PASAR A PEDIR 
 -->

<?php
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas
session_start(); // Poder acceder a $_SESSION
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}

$farmaData = json_decode($_POST['farmaData']);
$cartMany = $_SESSION['cartMany'];
$cart = $_SESSION['cart'];


echo "<pre>";
// print_r($farmaData); 
if (count($farmaData) === 1) { //TODO EN 1 sola farmacia
  $place_holders = $_SESSION['placeholders'];

  $consul_getData = $pdo->prepare("SELECT fa.nombrefarmacia,fa.preciounitario, fo.*
    FROM farmacias fa,farmacofarmacias ff,farmacos fo
    WHERE ff.codfarmacia=fa.codfarmacia AND ff.codfarmaco=fo.codfarmaco 
    AND fa.nombrefarmacia = ? AND fo.codfarmaco in ($place_holders)");
  $consul_getData->execute($farmaData[0]);
  $resultKnowFarma = $consul_getData->fetchAll();

  for ($i = 0; $i < count($cart); $i++) {
    $resultKnowFarma[$i]["many"] = $cartMany[$i]["many"];
  }

  //pasar a pedir
  $_SESSION['farmacos'] = $resultKnowFarma;
} else { //TRABAJAMOS CON VARIAS FARMACIAS
  $_SESSION['farmacos'] = [];

  foreach ($farmaData as $farma) {

    $params = [];
    foreach ($cart as $item) {   //obtener el farmaco que se le pedira a la farmacia
      if (in_array($item, $farma)) {
        array_push($params, $item);
      }
    };

    // print_r($params);

    $place_holders = implode(',', array_fill(0, count($params), '?')); //PERMITE SUSTITUIR EN EL OPERADOR IN DE LA CONSULTA


    $consul_getData = $pdo->prepare("SELECT fa.nombrefarmacia, fo.*
      FROM farmacias fa,farmacofarmacias ff,farmacos fo
      WHERE ff.codfarmacia=fa.codfarmacia AND ff.codfarmaco=fo.codfarmaco 
      AND fa.nombrefarmacia = ? AND fo.codfarmaco in ($place_holders)");
    $consul_getData->execute($farma);
    $resultKnowFarma = $consul_getData->fetchAll();  //Traer datos del farmaco para mostrar en el UI pedir.php

    // print_r($cartMany);
    for ($i = 0; $i < count($params); $i++) {             //para cada farmaco que le pedire a la farmacia
      foreach ($cartMany as $arr) {                       //para cada elemento del carrtio
        if ($params[$i] ==  $arr['which']) {                  //Si ese elemento corresponde a lo que le pedi a la farmacia (xq vienen sin criterio)
          $resultKnowFarma[$i]["many"] = $arr["many"]; //Agregar cuanto se pedira
        }
      }
    }

    // print_r($resultKnowFarma);

    ////RESULT ME DA UN ARRAY DENTRO DE UN ARRAY, COMO NECESITO QUE SESION SEA UN ARRAY DE LOS PEDIDOS, SIMPLEMENTE PASO EL INTERIOR DE RESULT
    foreach ($resultKnowFarma as $res) {
      array_push($_SESSION['farmacos'], $res);
    }
  }
}

// print_r($_SESSION['farmacos']);
echo "</pre>";

header('Location: pedir.php');
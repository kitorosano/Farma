<?php

$linkConnect = 'mysql:host=localhost;dbname=farma';
$userConnect = 'root';
$passConnect = '';


try {
  $pdo = new PDO($linkConnect, $userConnect, $passConnect);
  // print_r("Conectado a la base de datos! <br><br><br>");


} catch (PDOException $e) {
  print "¡Error al conectarse a la base de datos!: <br>" . $e->getMessage() . "<br/>";
  die();
}

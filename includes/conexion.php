<?php
// $link = 'mysql: host=https://databases.000webhostapp.com;dbname=id14672585_test;port=3306';
// $user = 'id14672585_testuser';
// $pass = "Test123-321.";

$linkConnect = 'mysql:host=localhost;dbname=farma';
$userConnect = 'root';
$passConnect = 'Kebu123321';


try {
  $pdo = new PDO($linkConnect, $userConnect, $passConnect);
  // print_r("Conectado a la base de datos! <br><br><br>");


} catch (PDOException $e) {
  print "¡Error al conectarse a la base de datos!: <br>" . $e->getMessage() . "<br/>";
  die();
}

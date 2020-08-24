<?php

$link = 'mysql:host=localhost;dbname=farma';
$user = 'root';
$pass = 'Kebu123321';


try {
  $pdo = new PDO($link, $user, $pass);
  // print_r("Conectado a la base de datos! <br><br><br>");


  // foreach($pdo->query('SELECT * from colores') as $fila) {
  //     print_r($fila);
  // }}
} catch (PDOException $e) {
  print "¡Error al conectarse a la base de datos!: <br>" . $e->getMessage() . "<br/>";
  die();
}

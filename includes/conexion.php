<?php

// $linkConnect = 'postgres:host=localhost;dbname=farma';
// $userConnect = 'root';
// $passConnect = 'Kebu123321';
$db = parse_url(getenv("DATABASE_URL"));
// $db = parse_url('postgres://postgres:postgres@localhost:5432/farma');

try {
  // $pdo = new PDO($linkConnect, $userConnect, $passConnect);
  $pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
  ));
  // print_r("Conectado a la base de datos! <br><br><br>");


} catch (PDOException $e) {
  print "¡Error al conectarse a la base de datos!: <br>" . $e->getMessage() . "<br/>";
  die();
}
  
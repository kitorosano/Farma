<?php

include_once 'conexion.php';


$id = $_GET['id'];

$sql_eliminar = 'DELETE FROM colores WHERE id=?';
$consult_eliminar = $pdo->prepare($sql_eliminar);
$consult_eliminar->execute(array($id));

// cerramos conexion bd y consulta
$pdo = null;
$consult_eliminar = null;
header('location:index.php');
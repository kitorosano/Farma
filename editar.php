<?php


// echo 'editar.php?id=1&color=success&descripcion=Este es verde';
// echo '<br>';

$id = $_GET['id'];
$color = $_GET['color'];
$descripcion = $_GET['descripcion'];

// echo $id;
// echo '<br>';
// echo $color;
// echo '<br>';
// echo $descripcion;

include_once 'conexion.php';

$sql_editar = 'UPDATE colores SET color=?,descripcion=? WHERE id=?';
$consul_editar = $pdo->prepare($sql_editar);
$consul_editar->execute(array($color,$descripcion,$id));

// cerramos conexion bd y consulta
$pdo = null;
$consul_editar = null;
header('location:index.php');
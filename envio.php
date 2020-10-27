<?php


// echo 'editar.php?id=1&color=success&descripcion=Este es verde';
// echo '<br>';

$id = $_GET['id'];
// echo $id;

include_once 'includes/conexion.php';
$consul_editar = $pdo->prepare("UPDATE `pedidos` SET `status`='en camino' WHERE `idPedido`=?");
$consul_editar->execute(array($id));

$affectedRow = $consul_editar->rowCount();;
// print_r($affectedRow);


// cerramos conexion bd y consulta
$pdo = null;
$consul_editar = null;

if($affectedRow === 1) {
  echo "<script>window.close();</script>";
} else {
  echo "Algo salio mal";
};


// WRITE A FUNCTION ON FARMACIAS, TO ELIMINATE EL PEDIDO ENVIADO AND FOR THIS PAGE WAIT UNTIL THE QUERY FINISHED FOR CLOSE IT
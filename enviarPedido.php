<?php
include_once 'includes/conexion.php';
session_start();
if (isset($_SESSION['user'])) { //Si esta logueado
  // header('Location: .');
  
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  $date = date("Y/m/d H:i:s"); //ENVIAR HORA DE ENVIO
  echo "<pre>";

  // print_r($_SESSION['farmacos']);
  
  $whichFarmas = array_unique(array_column($_SESSION["farmacos"], 'nombreFarmacia'));
  foreach ($whichFarmas as $farma) {
    // for ($i = 0; $i < count($whichFarmas); $i++) {

      // GET CODFARMACIA PARA EL INSERT A PARTIR DEL NOMBRE DE LA FARMACIA (NO ES LO MAS EPICO PERO BUENO ES LO QUE HAY VALORE)
      $consul_getCodFarmacia = $pdo->prepare("SELECT codFarmacia FROM farmacias WHERE nombreFarmacia=?");
      $consul_getCodFarmacia->execute(array($farma));
      $codFarmacia = $consul_getCodFarmacia->fetch();
      // print_r($codFarmacia);
      
    $pedido = [$_SESSION['user'], $codFarmacia['codFarmacia'], $date, $_SESSION['userDir'],$_SESSION['userDirParse']->lat,$_SESSION['userDirParse']->lng];
    // print_r($pedido);

    $consul_sendPedido = $pdo->prepare("INSERT INTO pedidos (ciUsuario,codFarmacia,fecha,direccion,geoLat,geoLng) VALUES (?,?,?,?,?,?)");
    $consul_sendPedido->execute($pedido);
    $res = $consul_sendPedido->fetchALl();

    $lastInsert = $pdo->lastInsertId(); //Obtener el ultimo id agregado (idFarmacia)
    $consul_sendPedido->closeCursor(); //Para poder ejecutar la sig sentencia sin errores
    
    foreach ($_SESSION['farmacos'] as $elt) {
      if($elt['nombreFarmacia'] === $farma){
        
        $detPedido = [$lastInsert, $elt['codFarmaco'], $elt['many'], $elt["precioUnitario"]];
        // print_r($detPedido);
        
        $consul_sendDetPedido = $pdo->prepare("INSERT INTO detallepedidos (idPedido,codFarmaco,cantidad,precio) VALUES (?,?,?,?)");
        $consul_sendDetPedido->execute($detPedido);
      } 
    }
  };

  echo "</pre>";

  $user = $_SESSION['user'];

  $_SESSION = array(); //reinicializamos el array que guarda las variables

  $_SESSION['user'] = $user; //reiniciarmos al usuario para que cuando redireccione ya este logueado
}

header("location: .");
<!-- 
  PASAR LA DIRECCION DEL CLIENTE
  Y LA DISTANCIA DE CADA FARMACIA CON RESPECTO A LA DIRECCION DEL CLIENTE
 -->
<?php
session_start(); // Poder acceder a $_SESSION
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas

if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  echo "entrando";
  header('Location: .');
}



//OBTENER DATOS DEL CLIENTE CON SUS FARMACOS RECETADOS 
$consulUserFarmacos = $pdo->prepare("SELECT *
FROM usuarios u,farmacousuarios fu,farmacos f
WHERE fu.ciusuario=u.ciusuario AND fu.codfarmaco=f.codfarmaco
AND u.ciusuario=?");
$consulUserFarmacos->execute(array($_SESSION['user']));
$client = $consulUserFarmacos->fetchAll();

$_SESSION['userDir'] = $_POST['inAddress'];
$_SESSION['userDirParse'] = json_decode($_POST['inAddressParse']);
$_SESSION['count'] = $_POST['count'];
// echo "<pre>";
// print_r($_SESSION['userDirParse']->lat );
// echo "</pre>";

$cart = []; //solo cod de farmaco
$cartMany = []; //CUAL cod del farmaco y CUANTA cantidad se selecciono


// PARA CADA FARMACO SELECCIONADO, PUSHEAR AL CARRITO EL CODIGO DEL FARMACO Y LA CANTIDAD A PEDIR
for ($i = 1; $i < $_SESSION['count']; $i++) { //Count empieza desde 1
  if (!$_POST['inAñadir-' . $i] == 0) { //Para los paneles añadidos (pedidos)

    array_push($cart, $client[$i - 1]['codfarmaco']);

    array_push($cartMany, [
      "which" => $client[$i - 1]['codfarmaco'],
      "many" => $_POST['inAñadir-' . $i]
    ]);
  }
}

$_SESSION['cart'] = $cart;
$_SESSION['cartMany'] = $cartMany;

$params = [];
foreach ($cart as $item) {
  array_push($params, $item);
};
$place_holders = implode(',', array_fill(0, count($params), '?')); //PERMITE SUSTITUIR EN EL OPERADOR IN DE LA CONSULTA

$_SESSION['placeholders'] = $place_holders;
$_SESSION['params'] = $params;


//OBTENER GeoLocalidad de las farmacias
$consul_GeoLocation = $pdo->prepare("SELECT nombrefarmacia,fgeolat,fgeolng
FROM farmacias");
$consul_GeoLocation->execute();
$farmaData = $consul_GeoLocation->fetchAll();

// echo "<pre>";
// print_r($farmaData);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>calculando.</title>

  <form id="form1" action="calculate2.php" method="POST">
    <input name="farmaciaDistancia" id="farmaciaDistancia" hidden value="" />
    <input name="casaDireccion" id="casaDireccion" hidden value="" />
  </form>


  <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
  <script>
    const platform = new H.service.Platform({
      apikey: "MjT4Z-c7kBrLpicDHQm5hwj6HBNJIhYiYmjtdxAQK24",
    });

    //Llamar a los servicios de BUSQUEDA y RASTREO DE RUTA
    const service = platform.getSearchService();
    const router = platform.getRoutingService(null, 8);

    //Pasar de Direccion a Coordenadas, funciona con promesa.
    const geocoder = (query) => {
      return new Promise((resolve, reject) => {
        service.geocode({
            q: query + "Paysandu, Uruguay",
          },
          (success) => {
            resolve(success.items[0].position);
          },
          (error) => {
            reject(error);
          }
        );
      });
    };

    // const getLocals = () => {
    //   return new Promise((resolve, reject) => {
    //     fetch("includes/locals.json")
    //       .then((response) => response.json())
    //       .then((data) => resolve(data))
    //       .catch((error) => reject(error));
    //   })
    // };

    const start = async () => {
      // Marcador DIRECCION DEL CLIENTE
      const marker1 = new H.map.Marker({
        lat: <?php echo json_encode($_SESSION['userDirParse']->lat); ?>,
        lng: <?php echo json_encode($_SESSION['userDirParse']->lng); ?>
      });

      // const locals = await getLocals();
      const locals = <?php echo json_encode($farmaData)?>;
      let farmaciaDistancia = [];
      // let lastDistance = Infinity;
      for (let local of locals) {
        // console.log(local)

        const lat = local.fgeolat;
        const lng = local.fgeolng;
        const marker2 = new H.map.Marker({ lat,lng });
        const distance = marker1.getGeometry().distance(marker2.getGeometry());

        farmaciaDistancia.push({
          name: local.nombrefarmacia,
          distance: distance
        })

      }

      document.getElementById("farmaciaDistancia").value = JSON.stringify(farmaciaDistancia);
      // document.getElementById("form1").submit();
    };

    start();
  </script>
</head>

</html>
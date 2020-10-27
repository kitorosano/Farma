<!-- 
  PASAR A QUE FARMACIA/S SE LE REALIZARA EL PEDIDO 
 -->

<?php
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas
session_start(); // Poder acceder a $_SESSION
if (!isset($_SESSION['user'])) { //Si no esta logueado lo echa
  header('Location: .');
}

//VARIABLES DEL FORM
$farmaciaDistancia = json_decode($_POST['farmaciaDistancia']);
$place_holders = $_SESSION['placeholders'];
$params = $_SESSION['params'];
$cart = $_SESSION['cart'];
// $cartMany = $_SESSION['cartMany'];


// CONSULTA SABER QUE LOCALES TIENEN LOS PEDIDOS DEL CARRITO
$consul_WhichLocal = $pdo->prepare("SELECT f.nombrefarmacia, ff.codfarmaco
  FROM farmacias f, farmacofarmacias ff
  WHERE ff.codfarmacia=f.codfarmacia AND ff.codfarmaco in ($place_holders)");
$consul_WhichLocal->execute($params);
$resultWhichLocal = $consul_WhichLocal->fetchAll();
// print_r($resultWhichLocal);


echo "<pre>";
// print_r($farmaciaDistancia);
$allFarmas = [];
$lastFarma = "";
foreach ($resultWhichLocal as $farmacias) { //LA QUERY TRAE LAS ORDENES SEPARADAS DE SUS FARMACIAS, ACA SIMPLEMENTE SE JUNTAN 
  $newFarma = $farmacias["nombrefarmacia"];
  if ($lastFarma !== $newFarma) {
    $allFarmas[$farmacias["nombrefarmacia"]] = [];
    array_push($allFarmas[$farmacias["nombrefarmacia"]], $farmacias["nombrefarmacia"]);
  }

  foreach ($cart as $item) {
    if (in_array($item, $farmacias)) {
      array_push($allFarmas[$farmacias["nombrefarmacia"]], $item);
      echo "<br>";
    }
  }

  $lastFarma = $newFarma;
}

// print_r($allFarmas);

$todoCerca = [];
$noTodoCerca = [];
foreach ($allFarmas as $farmacia) {
  if (array_diff($cart, $farmacia) == []) { //Todo esta en una misma farmacia
    // echo "Todo esta en una misma farmacia";
    array_push($todoCerca, $farmacia);
  } elseif ($todoCerca === []) {
    // echo "Todo NO esta en una misma farmacia";
    array_push($noTodoCerca, $farmacia);
  }
  echo "<br>";
}
// print_r($todoCerca);
// print_r($noTodoCerca); //SI TODO CERCA TIENE ALGO, ESTA VARIABLE DIRECTAMENTE NO SE ACTIVA

if ($todoCerca !== []) { //VARIABLE A PASAR PARA EL CALCULATE.JS
  $toCalculate = true;
} else {
  $toCalculate = false;
}
echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>calculando..</title>

  <form id="form2" method="POST" action="calculate3.php">
    <input name="farmaData" id="farmaData" hidden value="" />
  </form>

  <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>

  <?php if ($toCalculate) : ?>
    <script>
      const platform = new H.service.Platform({
        apikey: "MjT4Z-c7kBrLpicDHQm5hwj6HBNJIhYiYmjtdxAQK24",
      });

      const start = () => {
        // Marcador DIRECCION DEL CLIENTE
        const marker1 = new H.map.Marker({
          lat: <?php echo json_encode($_SESSION['userDirParse']->lat); ?>,
          lng: <?php echo json_encode($_SESSION['userDirParse']->lng); ?>
        });
        
        let farmacias = <?php echo json_encode($farmaciaDistancia); ?>;
        let allFarmacias = <?php echo json_encode($todoCerca) ?>;

        let farma;
        let lastDistance = Infinity;
        for (const allFarmacia of allFarmacias) {
          // console.log(allFarmacia[0])

          const farmacia = farmacias.filter((obj) => (
            obj.name === allFarmacia[0]
          ))
          newDistance = farmacia[0].distance;

          if (newDistance < lastDistance) {
            // console.log(newDistance)
            farma = allFarmacia
            lastDistance = newDistance;
          }

        }
        // console.log([farma]);

        document.getElementById("farmaData").value = JSON.stringify([farma]);
        document.getElementById("form2").submit();
      };

      start();
    </script>
  <?php else : ?>

    <script>
      const platform = new H.service.Platform({
        apikey: "MjT4Z-c7kBrLpicDHQm5hwj6HBNJIhYiYmjtdxAQK24",
      });

      const start = () => {
        let allFarmacias = <?php echo json_encode($noTodoCerca) ?>;

        // Marcador DIRECCION DEL CLIENTE
        const marker1 = new H.map.Marker({
          lat: <?php echo json_encode($_SESSION['userDirParse']->lat); ?>,
          lng: <?php echo json_encode($_SESSION['userDirParse']->lng); ?>
        });

        // let farma;
        let all = [];
        for (const allFarmacia of allFarmacias) {
          // allFarmacia.splice(0, 1)
          all = [...all, allFarmacia];
        }

        // console.log(allNames);
        // console.log(all);
        // console.log("===============")

        let combinations = []; // ARRAY que contendra las combinaciones de posibles farmacias a pedir
        all.forEach((al1) => {
          all.forEach((al2) => {
            if (al2 !== al1) {
              al3 = al1.concat(al2)
              // console.log(al3);

              // SABER CUAL COMBINACION POSEE TODOS LOS ELEMENTOS DEL CARRITO
              let cart = <?php echo json_encode($cart) ?>;
              let allFounded = cart.every(ai => al3.includes(ai));

              // ORDENAR EL ARRAY PARA QUE LAS FARMACIAS QUEDEN AL FINAL
              if (allFounded) {
                al3.sort(function(a, b) {
                  return a > b;
                });
                // console.log(al3)

                if (combinations.length === 0) { //Si el array completo esta vacio, agregarlo de one
                  combinations.push(al3);
                } else {
                  let checkAllArrs = [];
                  const checkAllArr = combinations.every((arr, index) => { //Comprobar con cada elemento del array completo
                    const checkEachArr = arr.every((el, i) => { //Si cada elemento del subarray es igual a los del array a agregar
                      return el == al3[i]
                    })
                    // console.log(al3)
                    // console.log("es igual a: ");
                    // console.log(arr)
                    // console.log(checkEachArr);
                    // console.log(" - - - ")
                    return !checkEachArr; //Si es igual, entonces es un duplicado
                  })
                  // console.log(al3)
                  // console.log("es distinto de todos: ")
                  // console.log(checkAllArr);
                  if (checkAllArr) { //Si el array no es duplicado se agrega al las posibles combinaciones
                    combinations.push(al3);
                    // console.log("SE AGREGA al3")
                  } else {
                    // console.log("NO SE AGREGA al3")
                  }
                  // console.log("====================")
                }

              }
            }
          })
        })
        // console.log("Posibles combinaciones:")
        // console.log(combinations)


        // CONVERTIR LOS FARMACOS EN NUMEROS, Y DEJAR LAS FARMACIAS SOLO COMO STRING
        combDistances = []
        combinations.forEach((arr, index) => {
          let combNames = []; //Tener farmacias de la combinacion

          arr.forEach((el, i) => {
            if (!isNaN(Number(el))) {
              arr.splice(i, 1, Number(el))
            } else {
              combNames.push(el)
            }
          })

          //   //TRABAJAR CON CADA COMBINACION - OBTENER DISTANCIA TOTAL (SUMA AMBAS FARMACIAS)
          const farmacias = <?php echo json_encode($farmaciaDistancia); ?>; //Obtener distancia de las farmacias

          //   // Filtrar de todas las farmacias, aquellas que esten presentes en la combinacion
          combDistances.push(farmacias.filter(obj => combNames.indexOf(obj.name) >= 0));

        })
        // console.log(combDistances)
        // console.log(combinations)
        // console.log("========")

        let nearest;
        let lastDistance = Infinity;
        for (const combDistance of combDistances) {
          // console.log(comb)

          let newDistance = 0;
          combDistance.forEach(farmacia => {
            // console.log(farmacia.distance);
            newDistance += farmacia.distance

          })


          if (newDistance < lastDistance) {
            // console.log(newDistance)
            nearest = combDistance
            lastDistance = newDistance;
          }
        }

        // console.log(nearest)

        combNames = nearest.map(p => p.name)
        // console.log(combNames)

        // OBTENER DE COMBINACIONES, LA COMBINACION CUYA DISTANCIA HAYA SIDO LA MAS CERCANA
        nearest = combinations.filter(arr => {
          let preRes = true;
          combNames.forEach(item => {
            preRes = arr.indexOf(item) >= 0 && preRes

            // console.log(arr.indexOf(combNames[i]))
          })
          return preRes
        })[0]; //COMO ME DEVUELVE UN ARRAY ADENTRO DE OTRO ARRAY, YA LE PIDO QUE ME DE SOLO 1

        // nearest = nearest.map(String);
        nearest = nearest.map(el => el.toString());

        console.log(combinations)
        console.log(nearest)
        console.log("========")

        farma = all.filter(arr => nearest.includes(arr[0]))

        // // ELIMINAR REPETIDOS, SIN NINGUN CRITERIO,
        farma.forEach((arr1) => {
          farma.forEach((arr2) => {
            if (arr1 !== arr2) {

              for (let i = arr1.length - 1; i > 0; i--) { //For loop inverso 
                for (let j = arr2.length - 1; j > 0; j--) { //mayor a 0 xq el primer lugar es el nombre y a mi me interesa solo los farmcos
                  if (arr1[i] == arr2[j]) {
                    arr2.splice(j, 1)
                  }
                }
              }

            }
          })
        })

        // console.log(farma);

        document.getElementById("farmaData").value = JSON.stringify(farma);
        document.getElementById("form2").submit();
      };

      start();
    </script>

  <?php endif ?>

</head>

</html>
<?php

include_once "conexion.php";

//Leer de la BD
  $consulta = $pdo->prepare("SELECT * FROM colores");
  $consulta->execute();
  $resultado = $consulta->fetchAll();
//

// AGREGAR
if($_POST){
  $color = $_POST['color'];
  $descripcion = $_POST['descripcion'];

  $sql_agregar = 'INSERT INTO colores (color,descripcion) VALUES (?,?)';
  $consul_agregar = $pdo->prepare($sql_agregar);
  $consul_agregar->execute(array($color,$descripcion));

  //cerramos conexion bd y consulta
  $consul_agregar = null;
  $pdo = null;
  header('location:index.php');
}

if($_GET){
  $id = $_GET['id'];
  //Leer de la BD
  $consul_id = $pdo->prepare("SELECT * FROM colores WHERE id=?");
  $consul_id->execute(array($id));
  $resultado_id = $consul_id->fetch();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Referencing CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/24904b643a.js" crossorigin="anonymous"></script>

    <title>Tutorial</title>
</head>

<body>

    <div class="container-fluid mt-5 pr-4">
        <div class="row">
            <div class="col-8">
                <?php foreach($resultado as $dato):?>

                <div class="alert alert-<?php echo $dato['color']?> text-uppercase" role="alert">
                    <?php echo $dato['color']?>
                    -
                    <?php echo $dato['descripcion']?>

                    <a href="eliminar.php?id=<?php echo $dato['id']?>" class="float-right ml-2"><i
                            class="fas fa-trash-alt"></i></a>
                    <a href="index.php?id=<?php echo $dato['id']?>" class="float-right"><i
                            class="fas fa-pencil-alt"></i></a>
                </div>

                <?php endforeach ?>
            </div>

            <div class="col-4">
                <!-- FORMULARIO PARA AGREGAR -->
                <?php if(!$_GET): ?>

                <h4>AGREGANDING...</h2>
                    <form method="POST">
                        <input type="text" class="form-control" name="color" placeholder="color">
                        <input type="text" class="form-control my-5" name="descripcion" placeholder="descripcion">
                        <button class="btn btn-primary">Agregar</button>
                    </form>

                    <?php endif?>
                    <!-- FORMULARIO AGREGAR -->

                    <!-- FORMULARIO PARA EDITAR -->
                    <?php if($_GET): ?>

                    <h4>EDITANDING...</h2>
                        <form method="GET" action="editar.php">
                            <input type="hidden" name="id" class="d-none" value="<?php echo $resultado_id['id'] ?>">
                            <input type="text" class="form-control" name="color" placeholder="color"
                                value="<?php echo $resultado_id['color'] ?>">
                            <input type="text" class="form-control my-5" name="descripcion" placeholder="descripcion"
                                value="<?php echo $resultado_id['descripcion'] ?>">
                            <button class="btn btn-<?php echo $resultado_id['color'] ?>">Editar</button>
                        </form>

                        <?php endif?>
                        <!-- FORMULARIO EDITAR -->
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
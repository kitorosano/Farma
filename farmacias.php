<?php session_start(); ?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Referencing CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/farmaSignIn.css" type="text/css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <title>Farmacias- Farma Uruguay</title>

</head>

<body>
    <?php if (!isset($_SESSION['farma'])) : ?>
        <div class="container-fluid">
            <!-- LOGO -->
            <div class="row justify-content-center">
                <a class="my-2" href="index.html">
                    <img class="mb-1" src="images/Logo1.png" width="300" alt="">
                </a>
            </div>
            <!-- LOGO -->

            <!-- FORMULARIOS -->
            <form action="login_farmacias.php" method="POST" class="form-signin">
                <h4 class="mb-3 font-weight-normal pb-3">Inicio de Sesion Farmacias</h4>

                <label for="codFarma">Codigo Farmacia:</label>
                <input name="codFarma" type="text" id="codFarma" class="form-control mb-3" required autofocus>

                <label for="passFarma mb-3">Contraseña:</label>
                <input name="passFarma" type="password" id="passFarma" class="form-control" required>

                <div class="d-flex justify-content-between">
                    <a href="." class="btn btn-link">Volver</a>
                    <button class="btn btn-primary" type="submit">Entrar</button>
                </div>
            </form>
            <!-- FORMULARIOS -->


        </div>
    <?php endif ?>

    <!-- SESION INICIADA -->
    <?php if (isset($_SESSION['farma'])) :

        include_once "includes/conexion.php";

        //Leer de la BD y obtener los datos del farmacias x farmacos
        $consulPedidos = $pdo->prepare("SELECT farmacias.*,pedidos.*,usuarios.nombreUsuario
            FROM farmacias,pedidos,usuarios
            WHERE pedidos.idFarmacia=farmacias.idFarmacia AND pedidos.ciUsuario=usuarios.ciUsuario
            AND farmacias.codFarmacia=?");
        $consulPedidos->execute(array($_SESSION['farma']));
        $fPedido = $consulPedidos->fetchAll();
        $consulPedidos->closeCursor();
    ?>

        <div class="container">
            <h1>Sesion Iniciada para <?php echo $fPedido[0]['nombreFarmacia'] ?></h1>
            <br>

            <div id="farmaMenu" class="container">
                <div class="d-flex flex-column py-2">
                    <button id="btnBandeja" class="btn btn-danger p-5 align-items-start">Revisar pedidos entrantes</button>
                </div>
                <div class="d-flex flex-column py-2">
                    <button id="btnStock" class="btn btn-warning p-5 align-items-end">Ver Farmacos en stock</button>
                </div>

                <br><br>
                <a href="logout.php">Cerrar sesion</a>
            </div>

            <!-- SELECCIONAR FARMACOS Y DIRECCION -->
            <div id="farmaPedidos" class="container" style="display:none">
                <div class="row">
                    <div class="accordion w-100" id="listaPedidos">

                        <?php $count = 1;
                        foreach ($fPedido as $eltPedido) :
                        ?>

                            <div class="card border-dark bg-light">
                                <div class="card-header" id="heading-<?php echo $count; ?>">
                                    <button class="btn btn-block collapsed p-0" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $count; ?>" aria-expanded="false">
                                        <div class="d-flex justify-content-between">
                                            <span style="font-size: 18px;"><b> # <?php echo $eltPedido['idPedido'] ?> </b></span>
                                            <span class="text-muted">Fecha: <?php echo $eltPedido['fecha']; ?></span>
                                        </div>
                                    </button>
                                </div>

                                <div id="collapse-<?php echo $count; ?>" class="collapse" aria-labelledby="heading-<?php echo $count; ?>" data-parent="#listaPedidos">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div class="align-center">
                                                    <h4 class="card-title text-monospace">Pedido del CI: <?php echo $eltPedido['ciUsuario'] ?></h4>
                                                </div>
                                            </div>
                                            <div class="col-2 pr-0 text-left">
                                                <p class="card-text px-3">Nombre Cliente: </p>
                                                <hr class="w-100 pr-0">
                                                <p class="card-text px-3">Dirección: </p>
                                            </div>
                                            <div class="col-4 pl-0 text-center">
                                                <p class="card-text px-3"><?php echo $eltPedido['nombreUsuario']; ?></p>
                                                <hr class="w-100 pl-0 ">
                                                <p class="card-text px-3"><?php echo $eltPedido['direccion']; ?></p>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="text-center mb-0 pb-0" style="background-color: rgba(0,0,0,.03);"><b>Lista de Farmacos</b></p>
                                        <div>
                                            <table class="table table-sm table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Codigo</th>
                                                        <th scope="col">Nombre</th>
                                                        <th scope="col">Sugerido</th>
                                                        <th scope="col">Precio Unit</th>
                                                        <th scope="col">Cantidad</th>
                                                        <th scope="col">Precio</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $consulDetPedidos = $pdo->prepare("SELECT *
                                                    FROM pedidos, detallepedidos, farmacos
                                                    WHERE detallepedidos.idPedido=pedidos.idPedido AND detallepedidos.idFarmaco=farmacos.idFarmaco
                                                    AND pedidos.idPedido=?");
                                                $consulDetPedidos->execute(array($eltPedido['idPedido']));
                                                $fDetPedido = $consulDetPedidos->fetchAll();

                                                foreach ($fDetPedido as $eltDetPedido) : ?>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center"><?php echo $eltDetPedido['codFarmaco']; ?></td>
                                                            <td class="text-center"><?php echo $eltDetPedido['nombreFarmaco']; ?></td>
                                                            <td class="text-center"><?php echo $eltDetPedido['nombreSugerido']; ?></td>
                                                            <td class="text-right">$ <?php echo $eltDetPedido['precioUnitario']; ?></td>
                                                            <td class="text-center"><?php echo $eltDetPedido['cantidad']; ?></td>
                                                            <td class="text-right">$ <?php echo ($eltDetPedido['precioUnitario'] * $eltDetPedido['cantidad']); ?></td>
                                                        </tr>
                                                    </tbody>
                                                <?php endforeach; ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex flex-row justify-content-center align-items-center">
                                        <button class="btn btn-primary w-50" type="buttom">Confirmar Envio</button>
                                    </div>
                                    <input type="hidden" name="count" value="<?php echo $count; ?>">
                                </div>
                                <!-- END COLLAPSE -->
                            </div>
                            <!-- END CARD -->
                        <?php $count++;
                        endforeach; ?>

                    </div>
                    <!-- END ACORDEON -->
                    <!-- VOLVER 1 Y CONTINUAR -->
                    <br>
                    <div class="row">
                        <button type="button" id="btnVolver1" class="btn btn-link">Volver</button>
                    </div>
                    <br>
                    <!-- END VOLVER Y CONTINUAR  -->
                </div>
                <!-- END ROW -->
            </div>
            <!-- END SELECCIONAR FARMACOS Y DIRECCION -->
        </div>
        <!-- CONTAIENR -->

    <?php endif ?>
    <!-- END SESION INICIADA -->

    <!-- Referencing JS files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/p5.js"></script> -->
    <script>
        $(document).ready(function() {

            //TRANSICION DE BOTONES
            $("#btnBandeja").click(function() {
                $("#farmaMenu").hide(1000);
                $("#farmaPedidos").fadeIn(2000);
            });
            $("#btnVolver1").click(function() {
                $("#farmaPedidos").hide(500);
                $("#farmaMenu").show(2000);
            });
        });
    </script>

</body>

</html>
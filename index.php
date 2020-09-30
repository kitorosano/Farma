<?php session_start(); ?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Referencing CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />

    <!-- Referencing Fontawesome Icons (THIS MUST GO IN THE 'HEAD' TAG) -->
    <script src="https://kit.fontawesome.com/24904b643a.js" crossorigin="anonymous"></script>

    <title>Farma Uruguay</title>


</head>

<body>
    <!-- SESION NO INICIADA -->
    <?php if (!isset($_SESSION['user'])) : ?>
        <section style="background-color: #d9eafa;">

            <!-- LOGO -->
            <div class="container d-flex justify-content-center">
                <a class="row mt-3" href="index.html">
                    <img class="mb-1" src="images/Logo1.png" width="300" alt="">
                </a>
            </div>
            <!-- END LOGO -->

            <!-- FORMULARIOS -->
            <div class="login mx-auto" style="width: 500px;">
                <div class="container shadow p-4 mb-2 bg-white rounded">

                    <h4 class="mb-4">Inicio de Sesion</h4>
                    <form action="login.php" method="POST">

                        <label for="ciUser"> Documento CI:</label>
                        <input type="text" class="form-control mb-3 required input" name="ciUser" autocomplete="false" value="">

                        <label for="passUser"> Contraseña:</label>
                        <input type="password" class="form-control mb-3 required input" name="passUser" autocomplete="false" value="">

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="farmacias.php">Iniciar como farmacia?</a>
                            <button class="btn btn-primary" type="submit">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- FORMULARIOS -->

        </section>
    <?php endif ?>
    <!--  -->

    <!-- SESION INICIADA -->
    <?php
    if (isset($_SESSION['user'])) :
        include_once "includes/conexion.php";

        //Leer de la BD y obtener los datos del usuario x farmacos
        $consulUserFarmacos = $pdo->prepare("SELECT *
            FROM usuarios,farmacousuarios,farmacos
            WHERE farmacousuarios.idUsuario=usuarios.idUsuario AND farmacousuarios.idFarmaco=farmacos.idFarmaco
            AND usuarios.ciUsuario=?");
        $consulUserFarmacos->execute(array($_SESSION['user']));
        $client = $consulUserFarmacos->fetchAll();

    ?>
        <nav class="navbar navbar-light" style="height: min-content; background-color: #e0f2ff;">
            <a class="navbar-brand" href="#">
                <img src="images/Logo1.png" width="110" height="50" alt="" loading="lazy">
            </a>

            <ul style="list-style: none;" class="pl-0 mb-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $client[0]['nombreUsuario']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href=".">Mi cuenta</a>
                        <a class="dropdown-item" href="#">Ayuda</a>
                        <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="container">
            <div id="userMenu" class="row justify-content-center">
                <div class="col-6 text-center">
                    <button id="btnPedido" class="btn btn-menu shadow btn-light p-5 align-items-start">Realizar Pedido</button>
                </div>
                <!-- <br> -->
                <div class="col-6 text-center">
                    <button id="btnRegistro" class="btn btn-menu shadow btn-light p-5 align-items-end">Ver Registro</button>
                </div>
            </div>

            <!-- SELECCIONAR FARMACOS Y DIRECCION -->
            <div id="MenuPedido" class="container" style="display:none">
                <form method="POST" action="calculate.php">
                    <div class="row row-cols-1 row-cols-md-2">
                        <?php $count = 1;
                        foreach ($client as $farmaco) : ?>

                            <div class="col mb-4">
                                <div class="card border-dark bg-light h-100">
                                    <div class="card-body">
                                        <h4 class="card-title text-monospace"><?php echo $farmaco['nombreSugerido']; ?></h4>
                                        <hr>
                                        <p class="card-text"><?php echo $farmaco['nombreFarmaco']; ?></p>
                                        <p class="card-text text-muted">Recetado: <?php echo $farmaco['fechaInicio']; ?></p>
                                    </div>
                                    <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                                        <input id="inAñadir-<?php echo $count; ?>" type="number" value="0" min="0" max="<?php echo $farmaco['cantidad']; ?>" class="text-center inAñadir" style="width:30%" name="inAñadir-<?php echo $count; ?>">
                                        <p class="card-text text-muted mb-0">Fecha Limite: <?php echo $farmaco['fechaFin']; ?></p>
                                        <div class="justify-content-end">
                                            <button type="button" id="btnAñadir-<?php echo $count; ?>" class="btn btn-info btnAñadir">Añadir </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php $count++;
                        endforeach ?>
                        <input type="hidden" name="count" value="<?php echo $count; ?>">
                    </div>

                    <!-- DIRECCION name=inAddress -->
                    <div class="form-group mt-3">
                        <label for="inAddress">Dirección a llevar:</label>
                        <input type="text" class="form-control" name="inAddress" id="inAddress" placeholder="Roger Balet 2186">
                    </div>
                    <!--  -->

                    <!-- VOLVER 1 Y CONTINUAR -->
                    <div class="row justify-content-between mt-5">
                        <!-- Button trigger modal -->
                        <button type="button" id="btnVolver1" class="btn btn-link">Volver</button>
                        <div class="justify-content-end">
                            <button id="btnContinuar" class="btn btn-success" type="button" data-toggle="modal" data-target="#modalDireccion">Continuar</button>
                        </div>
                    </div>
                    <!--  -->

                    <!-- MODAL (CONFIRMAR DIRECCION) -->
                    <div class="modal fade" id="modalDireccion" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="modalDireccionLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-center modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-bold" id="modalDireccionLabel">¿Es correcta esta direccion?</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span id="closeModal" aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div id="mapContainer" class="modal-body">
                                    <div id="map" class="" style="width: fit-content;height: 400px"></div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No. Señalar en el mapa</button> -->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" id="btnConfirm" class="btn btn-primary">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->

                </form>
                <!--  -->
                <br>
            </div>
            <!--  -->
        </div>
        <!--  -->

        </div>
    <?php endif ?>

    <!-- COPYRIGHT -->
    <footer>
        <p style="font-size: 1rem">&copy; Farma <script>
                document.write(new Date().getFullYear())
            </script>
        </p>
    </footer>
    <!-- -->

    <!-- Referencing JS from Bootstrap workflow -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Referencing JS for Non-Images work -->
    <script src="js/holder.js"></script>
    <!-- Referencing JS from HERE API, for Maps Services -->
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/calculate.js"></script>


    <script>
        $(document).ready(function() {
            <?php if (!isset($_SESSION['user'])) : ?>
                //TRANSICION DEL NAVBAR
                $(window).scroll(function() {

                    if ($('#miNavbar').offset().top > 100) {
                        // console.log("offset");
                        $('#miNavbar').removeClass("navbar-light");
                        $('#miNavbar').addClass("navbar-dark bg-dark");
                    } else {
                        $('#miNavbar').removeClass("navbar-dark bg-dark");
                        $('#miNavbar').addClass("navbar-light");
                    }


                });
                //
            <?php endif ?>
        });
    </script>

    <script>
        $(document).ready(function() {

            //TRANSICION DE BOTONES
            $("#btnPedido").click(function() {
                $("#userMenu").hide(1000);
                $("#MenuPedido").fadeIn(2000);
            })
            $("#btnRegistro").click(function() {
                $("#userMenu").fadeOut();
            })
            $("#btnVolver1").click(function() {
                map = null, fromMarker = null;

                $('.btnAñadir').prop("disabled", false).text("Añadir");
                $('.inAñadir').prop("disabled", false).prop("value", 0);

                $("#MenuPedido").hide(300);
                $("#userMenu").show(1500);
            });
            $('#btnContinuar').click(function() {
                start($('#inAddress').val());
            });

            $('#btnConfirm').click(function() {
                $('#modalDireccion').modal('hide')
                $("#MenuPedido").hide(1000);
                $("#MenuPedir").fadeIn(2000);

                $("#inDireccion").val($('#inAddress').val());

                $("#btnVolver2").click(function() {
                    map = null, fromMarker = null;
                    $("#MenuPedir").hide(300);
                    $("#MenuPedido").show(1500);
                });
                //

                // 
            });
            // ACCION BOTON AÑADIR DE LOS FARMACOS
            for (let i = 1; i < <?php echo $count; ?>; i++) {
                $('#btnAñadir-' + i).click(function() {
                    $(this).prop("disabled", true).text("Añadido"); //MAKE SO YOU CAN CANCEL AND TIPE AGAIN
                    $("#inAñadir-" + i).prop("readonly", true).addClass("text-muted").css("background-color", "rgba(0,0,0,.01)");
                })
            }
        });
    </script>

</body>

</html>
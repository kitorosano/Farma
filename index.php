<?php session_start(); ?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Referencing CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <link rel="stylesheet" href="css/estilos.css" type="text/css">

    <!-- Referencing Fontawesome Icons (THIS MUST GO IN THE 'HEAD' TAG) -->
    <script src="https://kit.fontawesome.com/24904b643a.js" crossorigin="anonymous"></script>

    <title>Farma Paysandú</title>

</head>

<body style="background-color: #ECEDEF;">
    <!-- SESION NO INICIADA -->
    <?php if (!isset($_SESSION['user'])) : ?>

        <!-- Inicio Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="miNavbar">
            <div class="container-fluid">
                <a class="navbar-brand logoName" href="index.html">
                    <img class="mr-2 mb-1" src="holder.js/100x57?theme=gray&outline=yes&text=Logo" alt="">
                    <b>Farma</b></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNavbar" aria-controls="collapseNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapseNavbar">
                    <div class="navbar-nav mx-5 px-5 d-flex justify-content-around">
                        <a class="nav-link active" href="#">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span class="off"> Inicio</span></a>
                        <a class="nav-link" href="#">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="off"> Nosotros</span></a>
                        <a class="nav-link " href="#">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                            <span class="off"> Servicios</span></a>
                        <a class="nav-link " href="#">
                            <i class="fa fa-file" aria-hidden="true"></i>
                            <span class="off"> Noticias</span></a>
                        <a class="nav-link " href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span class="off"> Contacto</span></a>
                    </div>
                    <div class="social d-flex flex-row justify-content-end">
                        <div><a href="#"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></div>
                        <div><a href="#"><i class="fab fa-twitter-square" aria-hidden="true"></i></a></div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Fin Navbar -->

        <!-- Inicio Carrusel Tutorial -->
        <div id="carruselTutorial" class="carousel slide " data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carruselTutorial" data-slide-to="0" class="active"></li>
                <li data-target="#carruselTutorial" data-slide-to="1"></li>
                <li data-target="#carruselTutorial" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active" style="height: 100vh">
                    <img data-src="holder.js/1920x1080?theme=vine&outline=yes&text=Insertar tutorial de como usar pagina" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" style="height: 100vh">
                    <img data-src="holder.js/1920x1080?theme=lava&outline=yes&text=Insertar tutorial de como usar pagina" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" style="height: 100vh">
                    <img data-src="holder.js/1920x1080?theme=social&outline=yes&text=Insertar tutorial de como usar pagina" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carruselTutorial" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carruselTutorial" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
        <!-- Fin Carrusel Tutorial -->

        <!-- FORMULARIOS -->
        <div class="login mx-auto" style="width: 500px;">
            <div class="container">
                <br>

                <div class="container" style="display: none;">
                    <h3>Registro de Usuario</h3>

                    <form class="d-flex flex-column" action="files/agregar_usuario.php" method="POST">
                        <input class="form-control m-1" type="text" name="ciUser" placeholder="Ingresa Documento">
                        <input class="form-control m-1" type="text" name="nameUser" placeholder="Ingresa Nombre">
                        <input class="form-control m-1" type="password" name="passUser" placeholder="Ingresa Contraseña">
                        <input class="form-control m-1" type="password" name="passUser2" placeholder="Ingresa nuevamente la contraseña">
                        <button class="btn btn-primary m-2" type="submit">Guardar</button>
                    </form>
                </div>


                <h4 class="mb-4">Inicio de Sesion</h2>
                    <form action="login.php" method="POST">

                        <label for="ciUser"> Documento CI:</label>
                        <input type="text" class="form-control mb-3 required input" name="ciUser" autocomplete="false" value="">
                        <!-- <label for="username"> Nombre:</label>
                    <input type="text" class="form-control mb-3 required input" name="nameUser" autocomplete="false"
                        value=""> -->
                        <label for="passUser"> Contraseña:</label>
                        <input type="password" class="form-control mb-3 required input" name="passUser" autocomplete="false" value="">
                        <button class="btn btn-primary float-right" type="submit">Entrar</button>

                        <a href="farmacias.php">Iniciar como farmacia?</a>
                    </form>

                    <br><br><br>

            </div>
        </div>
        <!-- FORMULARIOS -->

    <?php endif ?>
    <!--  -->

    <!-- SESION INICIADA -->
    <?php
    if (isset($_SESSION['user'])) :
        include_once "includes/conexion.php";

        //Leer de la BD y obtener los datos del usuario x farmacos
        $consulUserFarmacos = $pdo->prepare("SELECT *
            FROM usuarios,farmacousuarios,farmacos
            WHERE farmacousuarios.ciUsuario=usuarios.ciUsuario AND farmacousuarios.codFarmaco=farmacos.codFarmaco
            AND usuarios.ciUsuario=?");
        $consulUserFarmacos->execute(array($_SESSION['user']));
        $client = $consulUserFarmacos->fetchAll();
    ?>
        <div class="container">
            <h1>Sesion Iniciada para el usuario <?php echo $client[0]['nombreUsuario']; ?></h1>
            <br>

            <div id="userMenu" class="container">
                <div class="d-flex flex-column py-2">
                    <button id="btnPedido" class="btn btn-danger p-5 align-items-start">Realizar Pedido</button>
                </div>
                <!-- <br> -->
                <div class="d-flex flex-column py-2">
                    <button id="btnRegistro" class="btn btn-warning p-5 align-items-end">Ver Registro</button>
                </div>

                <br><br>
                <a href="logout.php">Cerrar sesion</a>
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
                                        <h4 class="card-title text-monospace"><?php echo $farmaco['nombreFarmaco']; ?></h4>
                                        <hr>
                                        <p class="card-text"><?php echo $farmaco['descripcion']; ?></p>
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
                    <div class="form-group">
                        <label for="inAddress">Dirección a llevar</label>
                        <input type="text" class="form-control" name="inAddress" id="inAddress" placeholder="Roger Balet 2186">
                    </div>
                    <!--  -->

                    <!-- VOLVER 1 Y CONTINUAR -->
                    <div class="row justify-content-between">
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


            <!-- ENVIAR PEDIDO -->
            <div id="MenuPedir" class="container" style="display: none;">
                <br>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Confirmar Cédula</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="12345678">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Contraseña</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="*********">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Dirección</label>
                        <input disabled type="text" class="form-control" id="inDireccion">
                    </div>
                </form>

                <!-- VOLVER 2 Y PEDIR-->
                <br>
                <div class="row justify-content-between">
                    <button id="btnVolver2" class="btn btn-link">Volver</button>
                    <div class="justify-content-end">
                        <button id="btnPedir" class="btn btn-danger" type="submit">Pedir!</button>
                    </div>
                </div>
                <br>
                <!--  -->
            </div>
            <!--  -->

        </div>
    <?php endif ?>
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
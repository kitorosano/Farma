<?php session_start(); ?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Referencing CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css" type="text/css">

    <!-- Referencing Fontawesome Icons (THIS MUST GO IN THE 'HEAD' TAG) -->
    <script src="https://kit.fontawesome.com/24904b643a.js" crossorigin="anonymous"></script>

    <title>Farma Paysandú (Github)</title>

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

        //Leer de la BD y obtener los datos del usuario
        $consulta = $pdo->prepare("SELECT *
        FROM usuarios,farmacousuarios,farmacos
        WHERE farmacousuarios.ciUsuario=usuarios.ciUsuario AND farmacousuarios.codFarmaco=farmacos.codFarmaco
        AND usuarios.ciUsuario=?");
        $consulta->execute(array($_SESSION['user']));
        $client = $consulta->fetchAll();
        $cliName = $client[0]['nombreUsuario'];


    ?>
        <div class="container">
            <h1>Sesion Iniciada para el usuario <?php echo $cliName ?></h1>
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
                <div class="row row-cols-1 row-cols-md-2">
                    <?php foreach ($client as $farmaco) : ?>

                        <div class="col mb-4">
                            <div class="card border-dark bg-light h-100">
                                <div class="card-body">
                                    <h4 class="card-title text-monospace"><?php echo $farmaco['nombreFarmaco'] ?></h4>
                                    <hr>
                                    <p class="card-text"><?php echo $farmaco['descripcion'] ?></p>
                                    <p class="card-text text-muted">Recetado: <?php echo $farmaco['fechaInicio'] ?></p>
                                </div>
                                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                                    <input id="inAñadir-<?php echo $farmaco['codFarmaco'] ?>" type="number" value="0" min="0" max="<?php echo $farmaco['cantidad'] ?>" class="text-center inAñadir" style="width:30%">
                                    <p class="card-text text-muted mb-0">Fecha Limite: <?php echo $farmaco['fechaFin'] ?></p>
                                    <div class="justify-content-end">
                                        <button id="btnAñadir-<?php echo $farmaco['codFarmaco'] ?>" class="btn btn-info btnAñadir">Añadir </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach ?>
                </div>
                <!-- DIRECCION -->
                <form method="POST">
                    <div class="form-group">
                        <label for="inAddress">Dirección a llevar</label>
                        <input type="text" class="form-control" id="inAddress" placeholder="Calle y Número de Casa">
                    </div>
                </form>
                <!--  -->
                <!-- VOLVER 1 Y CONTINUAR -->
                <div class="row justify-content-between">
                    <button id="btnVolver1" class="btn btn-link">Volver</button>
                    <div class="justify-content-end">
                        <button id="btnContinuar" class="btn btn-success">Continuar</button>
                    </div>
                </div>
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
                        <input type="text" class="form-control" id="inputAddress" placeholder="Calle y Número de Casa">
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

    <!-- Referencing JS files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/p5.js"></script> -->

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
            <?php if (isset($_SESSION['user'])) : ?>

                //TRANSICION DE BOTONES
                $("#btnPedido").click(function() {
                    $("#userMenu").hide(1000);
                    $("#MenuPedido").fadeIn(2000);
                })
                $("#btnRegistro").click(function() {
                    $("#userMenu").fadeOut();
                })
                $("#btnVolver1").click(function() {
                    cart = [];
                    $('.btnAñadir').prop("disabled", false).text("Añadir");
                    $('.inAñadir').prop("disabled", false).prop("value", 0);

                    $("#MenuPedido").hide(300);
                    $("#userMenu").show(1500);
                });
                $('#btnContinuar').click(function() {
                    $("#MenuPedido").hide(1000);
                    $("#MenuPedir").fadeIn(2000);

                    let userAddress = $('inAddress').value;



                    //WHERE DO I PUT THE DAMN DIRECCTION INPUT, SO I CAN RETRIEVE THOSE LOCATIONS AND DO DAT GUGUL STUFF

                    <?php
                    //Leer de la BD
                    $consul_local = $pdo->prepare("SELECT * 
                    FROM farmacias,farmacofarmacias,farmacos 
                    WHERE farmacofarmacias.codFarmacia=farmacias.codFarmacia AND farmacofarmacias.codFarmaco=farmacos.codFarmaco 
                    AND farmacos.codFarmaco=0;");
                    $consul_local->execute(array());
                    $resultado_local = $consul_local->fetch();
                    ?>
                    let localData = <?php echo json_encode($resultado_local); ?>;


                    console.log(cart, localData);
                });
                $("#btnVolver2").click(function() {
                    $("#MenuPedir").hide(300);
                    $("#MenuPedido").show(1500);
                });
                //

                // BOTON AÑADIR DE LOS FARMACOS
                let cart = [];
                for (let farmaco of <?php echo json_encode($client); ?>) {
                    let codFarmaco = farmaco.codFarmaco;
                    $('#btnAñadir-' + codFarmaco).click(function() {
                        let many = $("#inAñadir-" + codFarmaco)[0].value;

                        cart.push({
                            codFarmaco,
                            many
                        });

                        $(this).prop("disabled", true).text("Añadido");
                        $("#inAñadir-" + codFarmaco).prop("disabled", true);
                    })
                }
                // 

            <?php endif ?>
        });
    </script>

</body>

</html>


<?php
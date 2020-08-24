<?php session_start(); ?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Referencing CSS files -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css" type="text/css">

    <!-- Referencing Fontawesome Icons (THIS MUST GO IN THE 'HEAD' TAG) -->
    <script src="https://kit.fontawesome.com/24904b643a.js" crossorigin="anonymous"></script>

    <title>Farma Paysandú (Github)</title>

</head>

<body>
    <?php if (!isset($_SESSION['farma'])) : ?>

        <!-- Inicio Navbar -->
        <!-- <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="miNavbar">
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
        </nav> -->
        <!-- Fin Navbar -->

        <!-- Inicio Carrusel Tutorial -->
        <!-- <div id="carruselTutorial" class="carousel slide " data-ride="carousel">
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
        </div> -->
        <!-- Fin Carrusel Tutorial -->

        <!-- FORMULARIOS -->
        <div class="login mx-auto" style="width: 500px;">
            <div class="container">
                <br>

                <!-- <h3>Registro de Farmacias</h3>

                <form class="d-flex flex-column" action="agregar_farmacia.php" method="POST">
                    <input class="form-control m-1" type="text" name="codFarma" placeholder="Ingresa Codigo">
                    <input class="form-control m-1" type="text" name="nameFarma" placeholder="Ingresa Nombre">
                    <input class="form-control m-1" type="password" name="passFarma" placeholder="Ingresa Contraseña">
                    <input class="form-control m-1" type="password" name="passFarma2" placeholder="Ingresa nuevamente la contraseña">
                    <input class="form-control m-1" type="text" name="localFarma" placeholder="Ingresa Localidad">
                    <input class="form-control m-1" type="text" name="telFarma" placeholder="Ingresa Telefono">
                    <br>
                    <button class="btn btn-primary m-2" type="submit">Guardar</button>
                </form> -->
                <br><br>

                <h4 class="mb-4">Inicio de Sesion Farmacias</h2>
                    <form action="login_farmacias.php" method="POST">

                        <label for="codFarma"> Codigo Farmacia:</label>
                        <input type="text" class="form-control mb-3 required input" name="codFarma" autocomplete="false" value="">
                        <!-- <label for="nameFarma"> Nombre:</label>
                    <input type="text" class="form-control mb-3 required input" name="nameFarma" autocomplete="false"
                        value=""> -->
                        <label for="passFarma"> Contraseña:</label>
                        <input type="password" class="form-control mb-3 required input" name="passFarma" autocomplete="false" value="">
                        <button class="btn btn-primary float-right" type="submit">Entrar</button>
                    </form>

                    <br><br><br>
                    <a href="../" class="btn btn-link">Volver</button>

            </div>
        </div>
        <!-- FORMULARIOS -->

    <?php endif ?>

    <!-- SESION INICIADA -->
    <?php if (isset($_SESSION['farma'])) : ?>

        <div class="container">
            <h1>Sesion Iniciada para <?php echo $_SESSION['farma'] ?></h1>
            <br>

            <div id="farmaMenu" class="container">
                <div class="d-flex flex-column py-2">
                    <button id="btnBandeja" class="btn btn-danger p-5 align-items-start">Revisar pedidos entrantes</button>
                </div>
                <!-- <br> -->
                <div class="d-flex flex-column py-2">
                    <button id="btnStock" class="btn btn-warning p-5 align-items-end">Ver Farmacos en stock</button>
                </div>

                <br><br>
                <a href="../logout.php">Cerrar sesion</a>
            </div>

            <!-- <div id="MenuPedido" class="container" style="display:none">
                <div class="" style="width: 70vh;background-color: aliceblue;">

                    <div class="card bg-light mb-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Nombre</h5>
                            <p class="card-text">Breve descripcion del farmaco, o dato relevante al cliente.</p>
                            <a href="#" class="btn btn-primary">Pedir</a>
                        </div>
                    </div>
                </div>

            <br><br>
            <button id="btnVolver" class="btn btn-link">Volver</button> -->
        </div>


        </div>
    <?php endif ?>
    <!-- SESION INICIADA -->

    <!-- Referencing JS files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/holder.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/p5.js"></script> -->


    <script>
        //Transicion de color del navbar
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

        //fadeOut del boton Pedido
        $("#btnPedido").click(function() {
            $("#userMenu").hide(1000);
            $("#MenuPedido").fadeIn(2000);
        })

        //fadeOut del boton Registro
        $("#btnRegistro").click(function() {
            $("#userMenu").fadeOut();
        })

        //Boton volver
        $("#btnVolver").click(function() {
            $("#MenuPedido").hide(300);
            $("#userMenu").show(1500);
        })
    </script>

</body>

</html>


<?php
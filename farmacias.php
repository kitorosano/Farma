<?php
session_start(); // Poder acceder a $_SESSION
include_once "includes/conexion.php"; //Llamar a la variable para hacer las consultas

if ($_POST) {
	// enviar a la db
	$cod = $_POST['cod'];
	$stock = $_POST['stock'];

	// actualizar stock

	$consul_editar = $pdo->prepare('UPDATE farmacofarmacias SET stock=? WHERE codfarmacia=? AND codfarmaco=?');
	$consul_editar->execute(array($stock, $_SESSION['farma'], $cod));
	$result = $consul_editar->fetchAll();

	header('location: farmacias.php');
}

?>

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

	<title>Farmacias- Farma Uruguay</title>

</head>

<body>
	<!-- SESION NO INICIADA - LOGIN -->
	<?php if (!isset($_SESSION['farma'])) : ?>
		<section>
			<!-- LOGO -->
			<div class="container d-flex justify-content-center">
				<a class="row mt-3" href="index.html">
					<img class="mb-1" src="images/Logo1.png" width="300" alt="">
				</a>
			</div>
			<!-- LOGO -->

			<!-- FORMULARIOS -->
			<div class="login mx-auto" style="width: 500px;">
				<div class="container shadow p-4 mb-2 bg-white rounded">

					<h4 class="mb-4">Inicio de Sesion Farmacias</h4>
					<form id="formLogin" class="form-signin">

						<label for="codFarma">Codigo Farmacia:</label>
						<input name="codFarma" type="text" class="form-control mb-3" required>
						<!-- <div class="invalid-feedback"></div> -->

						<label for="passFarma mb-3">Contraseña:</label>
						<input name="passFarma" type="password" class="form-control" required>
						<!-- <div class="invalid-feedback"></div> -->
						<div class="" id="respuesta"></div>

						<div class="mt-4 d-flex justify-content-between">
							<a href="." class="btn btn-link">Volver</a>
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
	<?php if (isset($_SESSION['farma'])) :
		include_once "includes/conexion.php";

		//Leer de la BD y obtener los datos del usuario x farmacos
		$consulUserFarmacos = $pdo->prepare("SELECT nombrefarmacia, fgeolat, fgeolng FROM farmacias WHERE farmacias.codfarmacia=?");
		$consulUserFarmacos->execute(array($_SESSION['farma']));
		$data = $consulUserFarmacos->fetch();
		$consulUserFarmacos->closeCursor();

	?>
		<!-- BARRA ARRIBA -->
		<nav class="navbar navbar-light" style="height: min-content; background-color: #e0f2ff;">
			<a class="navbar-brand" href="#">
				<img src="images/Logo1.png" width="110" height="50" alt="" loading="lazy">
			</a>

			<ul style="list-style: none;" class="pl-0 mb-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $data['nombrefarmacia']; ?>
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
			<!-- MENU PRINCIPAL - BOTONES -->
			<div id="farmaMenu" class="row menu justify-content-center" style="margin-top: 20vh;">
				<div class="col-6 text-center">
					<button id="btnBandeja" class="btn btn-menu shadow btn-light p-5 align-items-start">Revisar pedidos entrantes</button>
				</div>
				<div class="col-6 text-center">
					<button id="btnStock" class="btn btn-menu shadow btn-light p-5 align-items-end">Ver Farmacos en stock</button>
				</div>
			</div>

			<!-- VER PEDIDOS -->
			<div id="farmaPedido" class="container pedido" style="display:none">
				<div class="accordion w-100 my-2" id="listaPedidos">
					<?php
					//Leer de la BD y obtener los datos del farmacias x farmacos
					$consulPedidos = $pdo->prepare('SELECT f.*, p.*, u.nombreusuario
							FROM farmacias f,pedidos p,usuarios u
							WHERE p.codfarmacia=f.codfarmacia AND p.ciusuario=u.ciusuario
							AND f.codfarmacia=?  AND p.estado="pendiente"');
					$consulPedidos->execute(array($_SESSION['farma']));
					$fPedido = $consulPedidos->fetch();
					$consulPedidos->closeCursor();

					print_r($fPedido);

					if (count($fPedido) === 0) : ?>

						<div class="card border-dark bg-light mt-5">
							<div class="card-header" id="heading-0">
								<h3>Actualmente, no hay pedidos entrantes</h3>
							</div>
						</div>

					<?php endif;

					$count = 1;
					foreach ($fPedido as $eltPedido) :
						$geo = $eltPedido['geolat'] . "," . $eltPedido['geolng'];
					?>

						<!-- CARD -->
						<div id="mycard-<?php echo $count; ?>" class="card border-dark bg-light">
							<!-- CARD HEADER -->
							<div class="card-header" id="heading-<?php echo $count; ?>">
								<button class="btn btn-block collapsed p-0" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $count; ?>" aria-expanded="false">
									<div class="d-flex justify-content-between">
										<span style="font-size: 18px;"><b> # <?php echo $count ?> </b></span>
										<span id="fecha-<?php echo $count ?>" class="text-muted">Fecha: <?php echo $eltPedido['fecha']; ?></span>
									</div>
								</button>
							</div>

							<!-- COLLAPSE -->
							<div id="collapse-<?php echo $count; ?>" class="collapse" aria-labelledby="heading-<?php echo $count; ?>" data-parent="#listaPedidos">

								<!-- <form action="GET"> -->
								<!--CARD BODY - DATOS DEL PEDIDO -->
								<div class="card-body">
									<!-- PARTE ARRIBA -->
									<div class="row">
										<!-- IZQUIERDA -->
										<div class="col-6 text-center">
											<!-- CEDULA -->
											<div class="align-center">
												<h4 class="card-title text-monospace">Pedido del CI: <?php echo $eltPedido['ciusuario'] ?></h4>
											</div>
											<!-- MAPA -->
											<div class="align-center mt-3">
												<button id="btnMapa-<?php echo $count; ?>" type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#mapaModal" data-where="<?php echo $geo; ?>">Mostrar en mapa</button>
											</div>

										</div>
										<!-- CENTRO -->
										<div class="col-2 pr-0 text-left">
											<p class="card-text px-3">Nombre Cliente: </p>
											<hr class="w-100 pr-0">
											<p class="card-text px-3">Dirección: </p>
										</div>
										<!-- DERECHA -->
										<div class="col-4 pl-0 text-center">
											<p class="card-text px-3"><?php echo $eltPedido['nombreusuario']; ?></p>
											<hr class="w-100 pl-0 ">
											<p class="card-text px-3"><?php echo $eltPedido['direccion']; ?></p>
										</div>
									</div>
									<br>
									<!-- PARTE ABAJO -->
									<div>
										<p class="text-center mb-0 pb-0" style="background-color: rgba(0,0,0,.03);"><b>Lista de Farmacos</b></p>
										<table class="table table-sm table-bordered table-hover table-responsive-md mb-0">
											<thead>
												<tr class="text-center ">
													<th style="width: 5%;" scope="col">Codigo</th>
													<th style="width: 40%;" scope="col">Nombre</th>
													<th style="width: 20%;" scope="col">Sugerido</th>
													<th style="width: 15%;" scope="col">Precio Unit</th>
													<th style="width: 5%;" scope="col">Cantidad</th>
													<th style="width: 15%;" scope="col">Precio</th>
												</tr>
											</thead>
											<?php
											$consulDetPedidos = $pdo->prepare("SELECT *
                                                    FROM pedidos p, detallepedidos dp, farmacos f
                                                    WHERE dp.idpedido=p.idpedido AND dp.codfarmaco=f.codfarmaco
                                                    AND p.idpedido=?");
											$consulDetPedidos->execute(array($eltPedido['idpedido']));
											$fDetPedido = $consulDetPedidos->fetchAll();
											// print_r($fDetPedido);

											foreach ($fDetPedido as $eltDetPedido) : ?>
												<tbody>
													<tr>
														<td class="text-center align-middle"><?php echo $eltDetPedido['codfarmaco']; ?></td>
														<td class="text-center align-middle"><?php echo $eltDetPedido['nombrefarmaco']; ?></td>
														<td class="text-center align-middle"><?php echo $eltDetPedido['nombresugerido']; ?></td>
														<td class="text-right align-middle">$ <?php echo $eltDetPedido['preciounitario']; ?></td>
														<td class="text-center align-middle"><?php echo $eltDetPedido['cantidad']; ?></td>
														<td class="text-right align-middle">$ <?php echo ($eltDetPedido['preciounitario'] * $eltDetPedido['cantidad']); ?></td>
													</tr>
												</tbody>
											<?php endforeach; ?>
										</table>
									</div>
								</div>

								<!-- CARD FOOTER -->
								<div class="card-footer d-flex flex-row justify-content-center align-items-center">
									<button id="enviar-<?php echo $count ?>" onclick="enviar(<?php echo $count ?>)" type="button" class="btn btn-primary w-50">Enviar Pedido</button>
									<!-- <a href="envio.php?id=" target="_blank" class="btn btn-primary w-50" type="button">Enviar Pedido</a> -->

									<div id="alert-<?php echo $count ?>" class="alert alert-success mb-0 d-none" role="alert">
										<strong>Pedido Enviado!</strong> Este pedido sera eliminado cuando se recargue la pagina.
									</div>
								</div>
								<!-- </form> -->

							</div>
							<!-- END COLLAPSE -->
						</div>
						<!-- END CARD -->
					<?php $count++;
					endforeach; ?>

				</div>
				<!-- END ACCORDION -->
				<br>



				<!-- VOLVER 1 Y CONTINUAR -->
				<div class="row">
					<button type="button" id="btnVolver1" class="btn btn-link">Volver</button>
				</div>

				<!-- MODAL (MAPA CON ROUTING) -->
				<div class="modal fade" id="mapaModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="mapaModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="mapaModalLabel">Como llegar a la direccion del cliente:</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div id="mapContainer" class="modal-body">
								<div id="map" class="" style="width: fit-content;height: 400px"></div>
							</div>
						</div>
					</div>
				</div>
				<!--  -->


			</div>

		</div>
		<!-- END VER PEDIDOS -->

		<!-- VER FARMACOS STOCK -->
		<div id="farmaStock" class="container pedido" style="display: none;">
			<ul class="">
				<?php
				//Leer de la BD y obtener el stock de los farmacos de la farmacia
				$consulFarmaFarmacos = $pdo->prepare("SELECT * FROM farmacias,farmacofarmacias,farmacos
                            WHERE farmacofarmacias.codfarmacia=farmacias.codfarmacia AND farmacofarmacias.codfarmaco=farmacos.codfarmaco
                            AND farmacias.codfarmacia=?");
				$consulFarmaFarmacos->execute(array($_SESSION['farma']));
				$farmacos = $consulFarmaFarmacos->fetchAll();
				// echo "<pre>";
				// print_r($farmacos);
				// echo "<!pre>";
				$count = 1;
				foreach ($farmacos as $farmaco) : ?>

					<form method="POST">
						<li class="list-group-item lh-condensed">
							<div class="row">
								<input type="hidden" name="cod" value="<?php echo $farmaco['codfarmaco'] ?>">
								<!-- NOMBRE -->
								<div class="col-4 text-left">
									<h6 class="my-0"><?php echo $farmaco['nombrefarmaco'] ?></h6>
									<small class="text-muted"><?php echo $farmaco['nombresugerido'] ?></small>
								</div>

								<!-- STOCK -->
								<div class="col-3 text-center">
									<button class="cantidad-<?php echo $count; ?> btn btn-light d-none" type="button" onclick="stockMenos(<?php echo $count; ?>)">
										<svg width="1.7rem" height="1.7rem" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
										</svg>
									</button>
									<!-- VALOR -->
									<span id="cantidadLabel-<?php echo $count ?>" class="mx-2">Stock: <?php echo $farmaco['stock'] ?></span>
									<input name="stock" id="stock-<?php echo $count; ?>" class="cantidad-<?php echo $count ?> text-center d-none" style="width: 60px;" value="<?php echo $farmaco['stock'] ?> ">
									<!-- END VALOR -->
									<button class="cantidad-<?php echo $count; ?> btn btn-light d-none" type="button" onclick="stockMas(<?php echo $count; ?>)">
										<svg width="1.7rem" height="1.7rem" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
										</svg>
									</button>
								</div>


								<div class="col-2 text-center">
									<span class="">$ <?php echo $farmaco['preciounitario'] ?></span>
								</div>

								<!-- PRECIO Y EDITAR -->
								<div class="col-3 text-right">
									<button type="button" id="btnEditar-<?php echo $count; ?>" class="btn btn-primary" onclick="handleEditar(<?php echo $count; ?>)">Editar</button>
									<button type="submit" id="btnSubmit-<?php echo $count; ?>" class="btn btn-success cantidad-<?php echo $count ?> d-none">Guardar</button>
								</div>

							</div>
						</li>
					</form>

				<?php $count++;
				endforeach ?>
				<input type="hidden" name="count" value="<?php echo $count; ?>">
			</ul>


			<!-- VOLVER 1 Y CONTINUAR -->
			<div class="row">
				<button type="button" id="btnVolver2" class="btn btn-link">Volver</button>
			</div>
			<!--  -->

		</div>
		<!-- END VER STOCK -->

		</div>

	<?php endif ?>
	<!-- END SESSION -->

	<!-- COPYRIGHT -->
	<footer>
		<p style="font-size: 1rem">&copy; Farma <script>
				document.write(new Date().getFullYear())
			</script>
		</p>
	</footer>
	<!-- -->

	<!-- Referencing JS files -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
	</script>
	<script src="js/bootstrap.min.js"></script>
	<!-- Referencing JS from HERE API, for Maps Services -->
	<script src="js/api.here.com.js"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>

	<?php if (isset($_SESSION['farma'])) : ?>
	<script>
		// MAPA
		/* Se utilizo Here API. */
		const platform = new H.service.Platform({
				apikey
			}),
			defaultLayers = platform.createDefaultLayers(),
			service = platform.getSearchService(),
			router = platform.getRoutingService(null, 8);


		//Calcular la ruta mas corta en auto, entre 2 puntos, promesa
		const calcularRoute = (start, finish) => {
			return new Promise((resolve, reject) => {
				const params = {
					routingMode: "fast",
					transportMode: "car",
					origin: start[0] + "," + start[1],
					destination: finish[0] + "," + finish[1],
					return: "polyline"
				};
				router.calculateRoute(params, success => {
					resolve(success.routes[0].sections);
				}, error => {
					reject(error);
				});
			});
		};
	</script>
	<script src="js/getMap.js"></script>
	<script>
		//TRANSICION DE BOTONES MENU
		$("#btnBandeja").click(function() {
			$("#farmaMenu").hide(1000);
			$("#farmaPedido").fadeIn(2000);
		});
		$("#btnVolver1").click(function() {
			$("#farmaPedido").hide(300);
			$("#farmaMenu").show(1500);
		});

		const enviar = which => {
			let enviado = false,
				boton = $('#enviar-' + which),
				alert = $('#alert-' + which),
				card = $('#heading-' + which),
				text = $('#fecha-' + which);

			window.open('envio.php?id=' + which, '_blank');
			enviado = true;

			// console.log(which)
			if (enviado) {
				boton.addClass('d-none');
				alert.removeClass('d-none');
				card.addClass('bg-success');
				text.removeClass('text-muted')
				// card.prop('style', 'background-color: #green');
			}

		}

		let mapReturn, markerReturn, routePolyline;
		$('#mapaModal').on('shown.bs.modal', async event => {
			let button = $(event.relatedTarget), // Button that triggered the modal
				data = button.data('where').split(','),
				latlng = [<?php echo json_encode($data['fgeolat']) ?>, <?php echo json_encode($data['fgeolng']) ?>];
			// console.log(data);

			if (!mapReturn) {
				mapReturn = mapStart(data);

				const farmaIcon = '<svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-shop" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
					'<path fill-rule="evenodd" d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>' +
					'</svg>';
				mapReturn.addObject(new H.map.Marker({
					lat: latlng[0],
					lng: latlng[1],
				}, {
					icon: new H.map.Icon(farmaIcon)
				}));
			}

			if (!markerReturn) {
				const markerIcon = '<svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-geo" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
					'<path fill-rule="evenodd" d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z"/>' +
					'</svg>';
				// Marcador DIRECCION DEL CLIENTE
				markerReturn = new H.map.Marker({
					lat: data[0],
					lng: data[1],
				}, {
					icon: new H.map.Icon(markerIcon)
				});

				mapReturn.addObject(markerReturn);
			}

			if (!routePolyline) {
				// Obtener la ruta
				routeOfLocals = await calcularRoute(latlng, data);

				// Mostrar en el mapa la ruta encontrada
				routeOfLocals.forEach(section => {
					let lineString = H.geo.LineString.fromFlexiblePolyline(section.polyline);
					routePolyline = new H.map.Polyline(
						lineString, {
							style: {
								strokeColor: 'blue',
								lineWidth: 5
							}
						});

					// Añadir al mapa lo encontrado y a mostrar
					mapReturn.addObject(routePolyline);

					// Que la vista del mapa se mueva para ver un pantallazo general de la ruta
					mapReturn.getViewModel().setLookAtData({
						bounds: routePolyline.getBoundingBox()
					});

				});


			}



		});

		const closeModal = () => {
			mapReturn.removeObjects([markerReturn, routePolyline]);
			markerReturn = null, routePolyline = null;
		}


		//TRANSICION DE BOTONES MENU
		$("#btnStock").click(function() {
			$("#farmaMenu").hide(1000);
			$("#farmaStock").fadeIn(2000);
		});
		$("#btnVolver2").click(function() {
			$("#farmaStock").hide(300);
			$("#farmaMenu").show(1500);
		});

		const handleEditar = (which) => {
			let botones = $('.cantidad-' + which),
				label = $('#cantidadLabel-' + which),
				editar = document.getElementById('btnEditar-' + which),
				input = document.getElementById('stock-' + which);


			if (botones[0].classList.contains('d-none')) {
				// ABRIR EDITAR 
				botones.removeClass('d-none');
				label.addClass('d-none')

				editar.innerText = "Cancelar";

			} else {
				// CERRAR EDITAR- ENVIO FORM
				botones.addClass('d-none');
				label.removeClass('d-none');

				editar.innerText = "Editar";
			}
		}

		const stockMenos = which => {
			let input = document.getElementById("stock-" + which);
			input.value = parseInt(input.value) - 1;
		}

		const stockMas = which => {
			let input = document.getElementById("stock-" + which);
			input.value = parseInt(input.value) + 1;
		}
	</script>
	<?php else : ?>
		<script>
			let formulario = document.getElementById('formLogin');
			let respuesta = document.getElementById('respuesta');

			formulario.addEventListener('submit', function(e) {
				e.preventDefault(); //evita procesar el form al url

				let datos = new FormData(formulario);

				fetch('login_farmacias.php', {
						method: 'POST',
						body: datos
					})
					.then(res => res.json())
					.then(data => {
						console.log(data);
						if (data !== "login") {
							respuesta.innerHTML = (`
						<div class="alert alert-danger" role="alert">
							${data}
						</div>
						`)
						} else {
							window.location.reload()
						}
					});
			});
		</script>
	<?php endif ?>

</body>

</html>
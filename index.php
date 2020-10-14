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
						<input type="text" name="ciUser" class="form-control mb-3 input" autocomplete="false" value="" required>
						<div class="invalid-feedback">

						</div>

						<label for="passUser"> Contraseña:</label>
						<input type="password" name="passUser" class="form-control mb-3 input" autocomplete="false" value="" required>
						<div class="invalid-feedback">

						</div>

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
	<?php if (isset($_SESSION['user'])) :
		include_once "includes/conexion.php";

		//Leer de la BD y obtener los datos del usuario x farmacos
		$consulUserFarmacos = $pdo->prepare("SELECT nombreUsuario FROM usuarios WHERE usuarios.ciUsuario=?");
		$consulUserFarmacos->execute(array($_SESSION['user']));
		$nombre = $consulUserFarmacos->fetch();

	?>
		<!-- BARRA NAVEGACION -->
		<nav class="navbar navbar-light" style="height: min-content; background-color: #e0f2ff;">
			<a class="navbar-brand" href="#">
				<img src="images/Logo1.png" width="110" height="50" alt="" loading="lazy">
			</a>

			<ul style="list-style: none;" class="pl-0 mb-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $nombre['nombreUsuario']; ?>
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
			<!-- MENU PRINCIPAL -->
			<div id="userMenu" class="row justify-content-center" style="margin-top: 20vh;">
				<div class="col-6 text-center">
					<button id="btnPedido" class="btn btn-menu shadow btn-light p-5 align-items-start">Realizar Pedido</button>
				</div>
				<div class="col-6 text-center">
					<button id="btnRegistro" class="btn btn-menu shadow btn-light p-5 align-items-end">Ver Registro</button>
				</div>
			</div>

			<!-- SELECCIONAR FARMACOS Y DIRECCION -->
			<div id="MenuPedido" class="container pedido" style="display:none">
				<form id="myform" method="POST" action="calculate1.php">
					<div class="row row-cols-1 row-cols-md-2 ">
						<?php
						//Leer de la BD y obtener los datos del usuario x farmacos
						$consulUserFarmacos = $pdo->prepare("SELECT * FROM usuarios,farmacousuarios,farmacos
                            WHERE farmacousuarios.ciUsuario=usuarios.ciUsuario AND farmacousuarios.codFarmaco=farmacos.codFarmaco
                            AND usuarios.ciUsuario=?");
						$consulUserFarmacos->execute(array($_SESSION['user']));
						$client = $consulUserFarmacos->fetchAll();

						$count = 1;
						foreach ($client as $farmaco) : ?>

							<div class="col my-2">
								<div id="cardFarmaco-<?php echo $count; ?>" class="card border-dark bg-light h-100">
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
						<div id="errorDiv" class="invalid-feedback col-md-12">
							* Asegurate de AÑADIR una cantidad del farmaco a pedir
						</div>
					</div>

					<!-- DIRECCION -->
					<div class="form-group mt-3">
						<label for="inAddress">Dirección a llevar:</label>
						<input type="text" class="form-control" name="inAddress" id="inAddress" placeholder="Roger Balet 2186" required>
						<div class="invalid-feedback">
							* Porfavor, ingrese la direccion a la cual sera enviado el pedido.
						</div>
						<input type="hidden" name="inAddressParse" id="inAddressParse">
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
						<div class="modal-dialog modal-dialog-centered modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title text-bold" id="modal-title">Asegurate de que la direccion sea la correcta</h4>
									<button id="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div id="mapContainer" class="modal-body">
									<div id="map" class="" style="width: fit-content;height: 400px"></div>
								</div>
								<div class="modal-footer d-flex justify-content-between">
									<div><button type="button" class="btn btn-danger" id="btnCancelarMap" data-dismiss="modal">Cancelar</button></div>
									<div>
										<button type="button" class="btn btn-secondary" id="btnSeñalarMap">Señalar en el mapa</button>
										<button type="submit" class="btn btn-primary" id="btnConfirmMap">Confirmar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--  -->

				</form>
				<br>
			</div>

			<!-- REGISTRO PEDIDOS -->
			<div id="userRegistro" class="container pedido" style="display: none;">
				<div class="accordion w-100 my-2" id="listaPedidos">
					<?php
					//Leer de la BD y obtener los datos del farmacias x farmacos
					$consulPedidos = $pdo->prepare("SELECT p.*
							FROM pedidos p,usuarios u
							WHERE p.ciUsuario=u.ciUsuario AND u.ciUsuario=?");
					$consulPedidos->execute(array($_SESSION['user']));
					$uRegistro = $consulPedidos->fetchAll();
					$consulPedidos->closeCursor();
					// print_r($uRegistro);

					if (count($uRegistro) === 0) : ?>

						<div class="card border-dark bg-light mt-5">
							<div class="card-header" id="heading-0">
								<h3>No hay pedidos registrados</h3>
							</div>
						</div>

					<?php endif;

					$count = 1;
					foreach ($uRegistro as $eltRegistro) :
					?>

						<!-- CARD -->
						<div id="mycard-<?php echo $count; ?>" class="mycard card border-dark bg-light mx-auto" style="width: 900px;">
							<!-- CARD HEADER -->
							<div class="card-header" id="heading-<?php echo $count; ?>">
								<button class="btn btn-block collapsed p-0" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $count; ?>" aria-expanded="false">
									<div class="d-flex justify-content-between">
										<span style="font-size: 18px;"><b> # <?php echo $count ?> </b></span>
										<span id="fecha-<?php echo $count ?>" class="text-muted">Fecha: <?php echo $eltRegistro['fecha']; ?></span>
									</div>
								</button>
							</div>



							<!-- COLLAPSE -->
							<div id="collapse-<?php echo $count; ?>" class="collapse" aria-labelledby="heading-<?php echo $count; ?>" data-parent="#listaPedidos">

								<!--CARD BODY - DATOS DEL PEDIDO -->
								<div class="card-body">
									<!-- PARTE ARRIBA -->
									<div class="row">
										<!-- IZQUIERDA -->
										<div class="col-3 text-right">
											<p class="card-text px-3">Status del pedido: </p>
										</div>
										<div class="col-3 text-left">
											<p class="card-text text-uppercase font-weight-bold px-3 status"><?php echo $eltRegistro['status']; ?></p>
										</div>
										<!-- DERECHA -->
										<div class="col-3 text-right">
											<p class="card-text px-3">Dirección: </p>
										</div>
										<div class="col-3 text-left">
											<p class="card-text text-uppercase px-3"><?php echo $eltRegistro['direccion']; ?></p>
										</div>
									</div>
									<br>
									<!-- PARTE ABAJO -->
									<div>
										<p class="text-center mb-0 pb-0" style="background-color: rgba(0,0,0,.03);"><b>Detalles del pedido</b></p>
										<table class="table table-sm table-bordered table-hover table-responsive-md mb-0">
											<thead>
												<tr class="text-center ">
													<th style="width: 37%;" scope="col">Nombre Farmaco</th>
													<th style="width: 23%;" scope="col">Nombre Sugerido</th>
													<th style="width: 5%;" scope="col">Cantidad</th>
													<th style="width: 15%;" scope="col">Precio Total</th>
													<th style="width: 20%;" scope="col">Farmacia</th>
												</tr>
											</thead>
											<?php
											$consulDetPedidos = $pdo->prepare("SELECT fa.nombreFarmacia, p.*, dp.*, f.*
                                                    FROM farmacias fa, pedidos p, detallepedidos dp, farmacos f
                                                    WHERE dp.idPedido=p.idPedido AND dp.codFarmaco=f.codFarmaco
                                                    AND p.codFarmacia=fa.codFarmacia AND p.idPedido=?");
											$consulDetPedidos->execute(array($eltRegistro['idPedido']));
											$fDetPedido = $consulDetPedidos->fetchAll();
											// print_r($fDetPedido);

											foreach ($fDetPedido as $eltDetPedido) : ?>
												<tbody>
													<tr>
														<td class="text-center align-middle"><?php echo $eltDetPedido['nombreFarmaco']; ?></td>
														<td class="text-center align-middle"><?php echo $eltDetPedido['nombreSugerido']; ?></td>
														<td class="text-center align-middle"><?php echo $eltDetPedido['cantidad']; ?></td>
														<td class="text-right align-middle">$ <?php echo ($eltDetPedido['precioUnitario'] * $eltDetPedido['cantidad']); ?></td>
														<td class="text-center align-middle"><?php echo $eltDetPedido['nombreFarmacia']; ?></td>
													</tr>
												</tbody>
											<?php endforeach; ?>
										</table>
									</div>
								</div>
							</div>
							<!-- END COLLAPSE -->
						</div>
						<!-- END CARD -->
					<?php $count++;
					endforeach; ?>

				</div>
				<!-- END ACCORDION -->
				<br>
				<!-- VOLVER 2 Y CONTINUAR -->
				<div class="row justify-content-between mt-5">
					<!-- Button trigger modal -->
					<button type="button" id="btnVolver2" class="btn btn-link">Volver</button>
				</div>
				<!--  -->
			</div>

		</div>
		<!--  -->
	<?php endif ?>
	<!--  -->

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
	<!-- Referencing JS from HERE API, for Maps Services -->
	<script src="js/api.here.com.js"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>

	<?php if (isset($_SESSION['user'])) : ?>
		<script type="text/javascript">
			/* Se utilizo Here API. */
			const platform = new H.service.Platform({
					apikey
				}),
				defaultLayers = platform.createDefaultLayers(),
				service = platform.getSearchService(),
				router = platform.getRoutingService(null, 8);

			// direc to geo
			const geocoder = (query) => {
				return new Promise((resolve, reject) => {
					service.geocode({
							q: query + " Paysandu, Uruguay",
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

			// geo to direc
			const reverseGeocode = (coords) => {
				return new Promise((resolve, reject) => {
					service.reverseGeocode({
							at: [coords.lat, coords.lng]
						},
						(success) => {
							resolve(success.items[0].address.label);
						},
						(error) => {
							reject(error);
						}
					);
				});
			};
		</script>
		<script type="text/javascript" src="js/getDirection.js"></script>
		<script type="text/javascript">
			$("#btnPedido").click(function() { //IR A PEDIR FARMACOS
				$("#userMenu").hide(1000);
				$("#MenuPedido").fadeIn(2000);
			})
			$("#btnVolver1").click(function() { //VOLVER AL MENU PRINCIPAL
				// map = null, fromMarker = null;

				$('.btnAñadir').prop("disabled", false).text("Añadir");
				$('.inAñadir').prop("disabled", false).prop("value", 0);

				$("#MenuPedido").hide(300);
				$("#userMenu").show(1500);
			});

			$("#btnContinuar").click(function(event) {
				var form = document.getElementById('myform');
				let inAñadirPass = Array.prototype.every.call($('.inAñadir'), elt => !elt.classList.contains('text-muted') || elt.value == '0');
				if (inAñadirPass) {
					// console.log(inAñadirPass)

					$('#errorDiv')[0].style.display = "block";

					for (let i = 1; i < <?php echo $count; ?>; i++) {
						if ($('#cardFarmaco-' + i)[0].classList.contains('border-dark') ||
							$('#cardFarmaco-' + i)[0].classList.contains('border-success')) {
							$('#cardFarmaco-' + i).removeClass('border-dark').removeClass('border-success').addClass('border-danger')
						}
					}
				} else {

					$('#errorDiv')[0].style.display = "none";

					for (let i = 1; i < <?php echo $count; ?>; i++) {
						$('#cardFarmaco-' + i).removeClass('border-danger').addClass('border-success');
					}
				}

				if (form.checkValidity() === false || inAñadirPass) { //SI alguno es true, ya lanza el error
					event.preventDefault()
					event.stopPropagation()
				}
				form.classList.add('was-validated')
			});

			let mapReturn, markerReturn, mapBehavior;
			$('#modalDireccion').on('shown.bs.modal', async () => { //APARECE EL MODAL, ES NECESARIO QUE CARGE EL MODAL PARA EL USO DEL MAPA
				let from = await geocoder($('#inAddress').val());
				document.getElementById("inAddressParse").value = JSON.stringify(from);

				if (!mapReturn) {
					mapReturn = mapStart();
					mapBehavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(mapReturn));
				}

				markerReturn = marker(from);
				// console.log(markerReturn.getGeometry());

				mapReturn.addObject(markerReturn);
				mapReturn.setCenter(from);
				mapReturn.setZoom(17);

				// EVENTO PARA MOVER EL MARKER
				mapReturn.addEventListener('dragstart', ev => { //AL COMENZAR EL ARRASTRE DEL MARCADOR
					if (puedeSeñalar) {
						var target = ev.target;
						if (target instanceof H.map.Marker || target instanceof H.map.DomMarker) mapBehavior.disable();
					}
				}, false);

				mapReturn.addEventListener('dragend', async ev => { //AL TERMINAR EL ARRASTRE DEL MARCADOR
					if (puedeSeñalar) {
						var target = ev.target;
						if (target instanceof H.map.Marker || target instanceof H.map.DomMarker) {
							mapBehavior.enable();
							mapReturn.setCenter(target.getGeometry());

							// console.log(markerReturn.getGeometry());
							document.getElementById("inAddressParse").value = JSON.stringify(markerReturn.getGeometry());

						}
					}
				}, false);

				mapReturn.addEventListener('drag', ev => { //AL MOVER EL MARCADOR
					if (puedeSeñalar) {
						var target = ev.target,
							pointer = ev.currentPointer;
						if (target instanceof H.map.Marker) {
							target.setGeometry(mapReturn.screenToGeo(pointer.viewportX, pointer.viewportY));
						}
					}
				}, false);

			});

			let puedeSeñalar = false;
			$('#btnSeñalarMap').click(function() { //CLICK EN EDITAR POSICION   
				puedeSeñalar = !puedeSeñalar;

				// console.log(puedeSeñalar);
				let title = document.getElementById("modal-title"),
					señalar = document.getElementById('btnSeñalarMap'),
					cancelar = document.getElementById('btnCancelarMap'),
					confirmar = document.getElementById('btnConfirmMap'),
					close = document.getElementById('closeModal'),
					footer = document.getElementsByClassName('modal-footer')[0];

				if (puedeSeñalar) { //AHORA PUEDE EDITAR
					title.innerText = "Arrastra el marcador al lugar donde se enviara el pedido...";

					señalar.classList.remove('btn-secondary');
					señalar.classList.add('btn-success')
					señalar.innerText = "Confirmar Direccion";

					confirmar.style.display = "none";
					cancelar.style.display = "none";
					close.style.display = "none";

					footer.classList.remove('justify-content-between');
					footer.classList.add('justify-content-center');

				} else { //AHORA NO PUEDE EDITAR
					title.innerText = "Asegurate de que la direccion sea la correcta";

					señalar.classList.remove('btn-success');
					señalar.classList.add('btn-secondary');
					señalar.innerText = "Señalar en el mapa"

					confirmar.style.display = "";
					cancelar.style.display = "";
					close.style.display = "";

					footer.classList.remove('justify-content-center');
					footer.classList.add('justify-content-between');
				}
			})


			$('#btnCancelarMap').click(() => { //BOTON CANCELAR DEL MODAL
				puedeSeñalar = false;
				mapReturn.removeObject(markerReturn);
			})
			$('#closeModal').click(() => { //CERRAR DEL MODAL
				puedeSeñalar = false;
				mapReturn.removeObject(markerReturn);
			})

			$('#btnConfirmMap').click(function() { //BOTON CONFIRMAR DEL MODAL
				$('#modalDireccion').modal('hide');
				$("#MenuPedido").hide(1000);
				$("#MenuPedir").fadeIn(2000);
			});

			$(window).keydown(function(event) { //EVITAR QUE SE ENVIE EL FORMULARIO CON LA TECLA 'ENTER'
				if (event.keyCode == 13) {
					event.preventDefault();
					return false;
				}
			});

			// ACCION BOTON AÑADIR/EDITAR DE LOS FARMACOS
			for (let i = 1; i < <?php echo $count; ?>; i++) {
				// let toggle = true;
				$('#btnAñadir-' + i).click(function() {
					$("#inAñadir-" + i).attr('readonly', (index, attr) => {
						if (attr == 'readonly') { //SI TIENE ACTIVA LA CLASE READONLY (SI EL INPUT ESTA ACTIVADO)
							$("#inAñadir-" + i).removeClass("text-muted").css("background-color", "rgb(255,255,255)");

							$(this).removeClass('btn-secondary').addClass('btn-info');
							$(this)[0].innerText = "Añadir";

							return false
						} else { //SI EL INPUT ESTA DESACTIVADO
							$("#inAñadir-" + i).addClass("text-muted").css("background-color", "rgba(0,0,0,.01)");

							$(this).removeClass('btn-info').addClass('btn-secondary');
							$(this)[0].innerText = "Editar";

							return true
						}
					});

				})
			}
		</script>

		<script>
			$("#btnRegistro").click(function() { //IR A PEDIR FARMACOS
				$("#userMenu").hide(1000);
				$("#userRegistro").fadeIn(2000);
			})
			$("#btnVolver2").click(function() { //VOLVER AL MENU PRINCIPAL
				$("#userRegistro").hide(300);
				$("#userMenu").show(1500);
			});

			for (let i = 1; i < $('.mycard').length; i++) {
				let status = $('#mycard-' + i).find(".status").text();
				if ( status == 'en camino') {
					$('#mycard-' + i).removeClass('bg-light');
					$('#mycard-' + i).prop('style', 'background-color: rgb(246, 249, 171); width: 900px;')

					$('#fecha-' + i).removeClass('text-muted');
				} else if(status == 'entregado') {
					
					$('#mycard-' + i).prop('style', 'background-color: rgb(197, 253, 182); width: 900px;')
				}
			}
		</script>
	<?php endif ?>

</body>

</html>
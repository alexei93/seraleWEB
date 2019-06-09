<!DOCTYPE HTML>
<!--
	Landed by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<!-- Actualizador -->
	<!-- <meta http-equiv="refresh" content="5" > -->
		
	<!-- Conexion a la base de datos para leer los estados actuales de los elementos -->
	
	<?php
		//Conexion database
		$con = mysqli_connect('localhost','root','');
		//Seleccionamos la base de datos
		mysqli_select_db($con,'arduino');
		
		//Seleccionamos nuestra peticion (campos especificos)
		//en nuesto caso tenemos los campos:
		$sql = "SELECT * from casa";
		
		/* ID | Objeto | Rele | Valor */
		$resultado = mysqli_query($con,$sql);
		$datos = mysqli_fetch_assoc($resultado);
		// console.log(datos);
		
		$resultado = mysqli_query($con,$sql);
		$datos = "";
		while($row = mysqli_fetch_assoc($resultado)) {
			$datos .= json_encode($row);               
		};
		// print_r($datos);
		
	?>
	
	
	<script type="text/javascript">
	
		var valores_iniciales = <?php echo json_encode($datos); ?>;
		console.log("Datos iniciales obtenidos: ");
		console.log(valores_iniciales);	
	
		function idleTimer() {
			var t;
			//window.onload = resetTimer;
			window.onmousemove = resetTimer; // catches mouse movements
			window.onmousedown = resetTimer; // catches mouse movements
			window.onclick = resetTimer;     // catches mouse clicks
			window.onscroll = resetTimer;    // catches scrolling
			window.onkeypress = resetTimer;  //catches keyboard actions

		   // function reload() {
				// console.log("AAA");
				// window.location = self.location.href;  //Reloads the current page
		   // }

		   function resetTimer() {
				clearTimeout(t);
				t = setTimeout(reload, 300);  // time is in milliseconds (1000 is 1 second)
			}
			
			function reload($valores_iniciales) {
				$.ajax({
					//the url to send the data to
					url: 'prueba.php',				
					type: "POST",
					data:{'pIniciales' : valores_iniciales},
					success: function(data){
						if(data == "Hay cambios"){
							location.reload();
							// console.log(data);
							// resetTimer()
						}
						else{
							console.log(data);
							resetTimer()
						}				
					}
				})
			}
		}
		
		idleTimer();
		
	</script>
	<script  type="text/javascript">
		
		function switcher($id, $room, $objeto, $rele, $valor, $reposo, $type){
			//get the input value
			console.log("switcher ->" + $type);
			
			//persiana
				if($type === "persiana"){
					$valor = document.getElementById('RangeFilter').value;
					console.log("El nuevo valor es: " + $valor);
				}
				
			//puerta garaje
			if ($type === "portalon"){
				$valor = document.getElementById('RangeFilter2').value;
				console.log("El nuevo valor es: " + $valor);
			}
				$.ajax({
					//the url to send the data to
					url: 'update.php',
					//the data to send to
					data: {pRoom : $room, pObjeto: $objeto,pRele: $rele,pValor: $valor,pID: $id,pReposo: $reposo,pType: $type},
					//type. for eg: GET, POST
					type: "POST"
					})
					//on success
					.done(function(data) {
						console.log("***********Success***************"); //You can remove here
						// location.reload();
					})
					//on error
					.fail(function() {
						console.log("***********Error***************"); //You can remove here
					})
				// comprobarDatos();
				
			
		}
		
		function comprobarDatos(){
			$.ajax({
				//the url to send the data to
				url: 'prueba.php',				
				type: "GET",
			})
			.done(function(data) {
				var valores_iniciales = data;
				console.log(valores_iniciales);
			})
			.fail(function(xhr) {
				console.log('error callback 2');
			})
		}
	</script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	
	<script type="text/javascript">
	function filterme(value) {
		  value = parseInt(value, 10); // Convert to an integer
		  if (value === 1) {
			$('#RangeFilter').removeClass('rangeAll', 'rangePassive').addClass('rangeActive');
			$('#posicionpersiana').text('Cerrada');
		  } else if (value === 2) {
			$('#RangeFilter').removeClass('rangeActive', 'rangePassive').addClass('rangeAll');
			$('#posicionpersiana').text('Entreabierta');
		  } else if (value === 3) {
			$('#RangeFilter').removeClass('rangeAll', 'rangeActive').addClass('rangePassive');
			$('#posicionpersiana').text('Abierta');
		  }
		}
	function filterme2(value) {
		  value = parseInt(value, 10); // Convert to an integer
		  if (value === 1) {
			$('#RangeFilter2').removeClass('rangeAll', 'rangePassive').addClass('rangeActive');
			$('#posicionportalon').text('Cerrado');
		  } else if (value === 2) {
			$('#RangeFilter2').removeClass('rangeActive', 'rangePassive').addClass('rangePassive');
			$('#posicionportalon').text('Abierto');
		  }
		}
	</script>
	<head>
		<title>SERALE Automatismos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="assets/css/main.css" />
		<!-- <link rel="stylesheet" href="assets/css/switches.css" /> -->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload landing">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1 id="logo"><a href="index.php">Bienvenido !!</a></h1>
					
					<nav id="nav">
						<ul>
							<li><a href="index.php">Panel de control</a></li>
							<!-- <li> -->
								<!-- <a href="#">Layouts</a> -->
								<!-- <ul> -->
									<!-- <li><a href="left-sidebar.html">Left Sidebar</a></li> -->
									<!-- <li><a href="right-sidebar.html">Right Sidebar</a></li> -->
									<!-- <li><a href="no-sidebar.html">No Sidebar</a></li> -->
									<!-- <li> -->
										<!-- <a href="#">Submenu</a> -->
										<!-- <ul> -->
											<!-- <li><a href="#">Option 1</a></li> -->
											<!-- <li><a href="#">Option 2</a></li> -->
											<!-- <li><a href="#">Option 3</a></li> -->
											<!-- <li><a href="#">Option 4</a></li> -->
										<!-- </ul> -->
									<!-- </li> -->
								<!-- </ul> -->
							<!-- </li> -->
							<li><a href="index.php" class="button primary">Contáctanos</a></li>
							<!-- <li><a href="#" class="button primary">Donde encontrarnos</a></li> -->
						</ul>
					</nav>
					
				</header>

			<!-- Banner -->
				<section id="banner">
					<div class="content">
						<header>
							
							<h2>SERALE, siéntete como en casa.</h2>
							<!-- <img src="images/pic01_mia.png" alt="" /> -->
							<p>Todo bajo control estés donde estés.</br></br></p>
							<img src="images/logo_Web_s.png" alt="" />
							</br></br>
							</br></br>
							<!-- <span class="image"><img src="images/header.jpg" alt="" /></span> -->
							<!-- <img src="images/header.jpg" alt="" /> -->
							<div class="box alt">
							<div class="row gtr-uniform">
								<p></p>
								<!-- LO DEJE AQU, TENGO LA CONEXION DE LA BASE DE DATOS YA PUESTA; AHORA HAY QUE CURRARSE EL SWITCH -->
								<section class="col-4 col-6-medium col-12-xsmall">									
									<h3>Salón</h3>									
									<table class="tg">
									  <tr>
										<th class="tg-0lax">										
											<label>Iluminación</label>
											<?php
												// $sql = "SELECT * from casa";
												$consulta_salon = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Salon'");
												$row = mysqli_fetch_array($consulta_salon);
												// echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4];
											?>											
										</th>
										<th class="tg-0lax">											
												<?php
												echo "<div class='onoffswitch'>";
												if ($row[4] == 1){
													echo "<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch' checked>";
												}
												else {
													echo "<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch' >";
												}
												echo "<label class='onoffswitch-label' for='myonoffswitch' onclick=switcher('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','boolean')>";
												?>
												<span class='onoffswitch-inner'></span>
												<span class='onoffswitch-switch'></span>
												</label>
												</div>
										</th>
									  </tr>
									</table>											
									

									<!-- <span class="icon alt major fa-area-chart"></span> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									<h3>Habitación</h3>
									<table class="tg">
									  <tr>
										<th class="tg-0lax">										
											<label>Persiana</label>
											<?php
												// $sql = "SELECT * from casa";
												$consulta_habitacion = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Habitacion'");
												$row = mysqli_fetch_array($consulta_habitacion);
												// echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].' '.$row[5];
											?>											
										</th>
										<th class="tg-0lax">
											<?php
											//Si esta en reposo, habilitamos el scroll, sino lo bloqueamos
											if($row[5] == 1){
												echo "<input type='range' id='RangeFilter' name='points' oninput=switcher('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','persiana') onchange='filterme(this.value);' min='1' class='rangeAll' max='3' value='$row[4]'>";
												// echo "<p> $row[4] </p>";
												if($row[4] == 1){
													echo "<span id='posicionpersiana'>Cerrada</span>";
												}
												elseif($row[4] == 2){
													echo "<span id='posicionpersiana'>Entreabierta</span>";
												}
												elseif($row[4] == 3){
													echo "<span id='posicionpersiana'>Abierta</span>";
												}
												else{echo "<span id='posicionpersiana'>Error</span>";}
											}
											else{
												echo "<span > En movimiento.. </span>";
												echo "<img src='images\loading.gif'/>";
											}
											?>

											<!-- /* <input type="range" id="RangeFilter" name="points" onchange="filterme(this.value);" min="1" class="rangeAll" max="3" value="2">
											<span id="posicionpersiana">Entreabierta</span> -->
										</th>
									</tr>
								</table>
									
									<!-- <span class="icon alt major fa-comment"></span> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">
									
									<h3>Garaje</h3>
									
									<table class="tg">
									  <tr>
									  	<th class="tg-0lax">										
											<label>Regleta</label>
											<?php
												// $sql = "SELECT * from casa";
												$consulta_garaje_regleta = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Garaje' AND `Objeto`='Regleta'");
												$row = mysqli_fetch_array($consulta_garaje_regleta);
												// echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4];
												// echo $row[3];
											?>	
										</th>
										<th class="tg-0lax">										
											<?php
												echo "<div class='onoffswitch'>";
												if ($row[4] == 1){
													echo "<input type='checkbox' name='onoffswitch3' class='onoffswitch-checkbox' id='myonoffswitch3' checked>";
												}
												else {
													echo "<input type='checkbox' name='onoffswitch3' class='onoffswitch-checkbox' id='myonoffswitch3' >";
												}
												echo "<label class='onoffswitch-label' for='myonoffswitch3' onclick=switcher('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','boolean')>";
												?>
												<span class='onoffswitch-inner'></span>
												<span class='onoffswitch-switch'></span>
												</label>
												</div>
										</th>
										
									</tr>
									<tr>
										<th class="tg-0lax">										
											<label>Portal</label>
											<?php
												// $sql = "SELECT * from casa";
												$consulta_garaje = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Garaje'");
												$row = mysqli_fetch_array($consulta_garaje);
												// echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].' '.$row[5];
											?>											
										</th>
										<th class="tg-0lax">
											<?php
											//Si esta en reposo, habilitamos el scroll, sino lo bloqueamos
											if($row[5] == 1){
												echo "<input type='range' id='RangeFilter2' name='points2' oninput=switcher('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','portalon') onchange='filterme2(this.value);' min='1' class='rangeAll' max='2' value='$row[4]'>";
												// echo "<p> $row[4] </p>";
												if($row[4] == 1){
													echo "<span id='posicionportalon'>Cerrada</span>";
												}												
												elseif($row[4] == 2){
													echo "<span id='posicionportalon'>Abierta</span>";
												}
												else{echo "<span id='posicionportalon'>Error</span>";}
												}
											else{
												echo "<span > En movimiento.. </span>";
												echo "<img src='images\loading.gif'/>";
											}
											?>

											<!-- /* <input type="range" id="RangeFilter" name="points" onchange="filterme(this.value);" min="1" class="rangeAll" max="3" value="2">
											<span id="posicionpersiana">Entreabierta</span> -->
										</th>
									</tr>
								</table>
									
									
									
									
									<!-- <span class="icon alt major fa-flask"></span> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								</section>
								<section class="col-4 col-6-medium col-12-xsmall">									
									<h3>Climatización</h3>									
									<table class="tg">
									  <tr>
										<th class="tg-0lax">										
											<label>Aire acondicionado</label>
											<?php
												// $sql = "SELECT * from casa";
												$consulta_clima_ventilador = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Climatizacion' AND `Objeto`='Ventilador'");
												$row = mysqli_fetch_array($consulta_clima_ventilador);
												// echo $row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4];
												// echo $row[3];
											?>											
										</th>
										<th class="tg-0lax">											
												<?php
												echo "<div class='onoffswitch'>";
												if ($row[4] == 1){
													echo "<input type='checkbox' name='onoffswitch2' class='onoffswitch-checkbox' id='myonoffswitch2' checked>";
												}
												else {
													echo "<input type='checkbox' name='onoffswitch2' class='onoffswitch-checkbox' id='myonoffswitch2' >";
												}
												echo "<label class='onoffswitch-label' for='myonoffswitch2' onclick=switcher('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','boolean')>";
												?>
												<span class='onoffswitch-inner'></span>
												<span class='onoffswitch-switch'></span>
												</label>
												</div>
										</th>
									  </tr>
									  <tr>
									  	<th class="tg-0lax">
									  		<label>Temperatura</label>
									  		<?php
									  			//Ejecuta la consulta php para el valor de la temperatura
												$consulta_clima_temp = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Climatizacion' AND `Objeto`='Temperatura (C)'");
												$row = mysqli_fetch_array($consulta_clima_temp);
												// echo $row[4];
											?>	
									  	</th>
									  	<th class="tg-0lax">
									  		<?php
									  			echo $row[4];
									  			echo " ºC";
									  		?>
									  	</th>
									  </tr>
									  <tr>
									  	<th class="tg-0lax">
									  		<label>Humedad relativa</label>
									  		<?php
									  			//Ejecuta la consulta php para el valor de la temperatura
												$consulta_clima_humedad = mysqli_query($con,"SELECT * FROM `casa` WHERE `Room`='Climatizacion' AND `Objeto`='Humedad relativa'");
												$row = mysqli_fetch_array($consulta_clima_humedad);
												// echo $row[4];
											?>	
									  	</th>
									  	<th class="tg-0lax">
									  		<?php
									  			echo $row[4];
									  			echo " %";
									  		?>
									  	</th>
									  </tr>
									</table>											
									

									<!-- <span class="icon alt major fa-area-chart"></span> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								</section>
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									
									<!-- <h3>Piscina</h3> -->
									<!-- <span class="icon alt major fa-file"></span> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									
									<!-- <h3>Massa arcu accumsan</h3> -->
									<!-- <span class="icon alt major fa-lock"></span> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
							</div>
						</div>
						</header>
						
					</div>
					<a href="#four" class="goto-next scrolly">Next</a>
				</section>

			<!-- One -->
				<!-- <section id="one" class="spotlight style1 bottom"> -->
					<!-- <span class="image fit main"><img src="images/pic02.jpg" alt="" /></span> -->
					<!-- <div class="content"> -->
						<!-- <div class="container"> -->
							<!-- <div class="row"> -->
								<!-- <div class="col-4 col-12-medium"> -->
									<!-- <header> -->
										<!-- <h2>Odio faucibus ipsum integer consequat</h2> -->
										<!-- <p>Nascetur eu nibh vestibulum amet gravida nascetur praesent</p> -->
									<!-- </header> -->
								<!-- </div> -->
								<!-- <div class="col-4 col-12-medium"> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet sed accumsan donec. -->
									<!-- Blandit orci porttitor semper. Arcu phasellus tortor enim mi -->
									<!-- nisi praesent dolor adipiscing. Integer mi sed nascetur cep aliquet -->
									<!-- augue varius tempus lobortis porttitor accumsan consequat -->
									<!-- adipiscing lorem dolor.</p> -->
								<!-- </div> -->
								<!-- <div class="col-4 col-12-medium"> -->
									<!-- <p>Morbi enim nascetur et placerat lorem sed iaculis neque ante -->
									<!-- adipiscing adipiscing metus massa. Blandit orci porttitor semper. -->
									<!-- Arcu phasellus tortor enim mi mi nisi praesent adipiscing. Integer -->
									<!-- mi sed nascetur cep aliquet augue varius tempus. Feugiat lorem -->
									<!-- ipsum dolor nullam.</p> -->
								<!-- </div> -->
							<!-- </div> -->
						<!-- </div> -->
					<!-- </div> -->
					<!-- <a href="#two" class="goto-next scrolly">Next</a> -->
				<!-- </section> -->

			<!-- Two -->
				<!-- <section id="two" class="spotlight style2 right"> -->
					<!-- <span class="image fit main"><img src="images/pic03.jpg" alt="" /></span> -->
					<!-- <div class="content"> -->
						<!-- <header> -->
							<!-- <h2>Interdum amet non magna accumsan</h2> -->
							<!-- <p>Nunc commodo accumsan eget id nisi eu col volutpat magna</p> -->
						<!-- </header> -->
						<!-- <p>Feugiat accumsan lorem eu ac lorem amet ac arcu phasellus tortor enim mi mi nisi praesent adipiscing. Integer mi sed nascetur cep aliquet augue varius tempus lobortis porttitor lorem et accumsan consequat adipiscing lorem.</p> -->
						<!-- <ul class="actions"> -->
							<!-- <li><a href="#" class="button">Learn More</a></li> -->
						<!-- </ul> -->
					<!-- </div> -->
					<!-- <a href="#three" class="goto-next scrolly">Next</a> -->
				<!-- </section> -->

			<!-- Three -->
				<!-- <section id="three" class="spotlight style3 left"> -->
					<!-- <span class="image fit main bottom"><img src="images/pic04.jpg" alt="" /></span> -->
					<!-- <div class="content"> -->
						<!-- <header> -->
							<!-- <h2>Interdum felis blandit praesent sed augue</h2> -->
							<!-- <p>Accumsan integer ultricies aliquam vel massa sapien phasellus</p> -->
						<!-- </header> -->
						<!-- <p>Feugiat accumsan lorem eu ac lorem amet ac arcu phasellus tortor enim mi mi nisi praesent adipiscing. Integer mi sed nascetur cep aliquet augue varius tempus lobortis porttitor lorem et accumsan consequat adipiscing lorem.</p> -->
						<!-- <ul class="actions"> -->
							<!-- <li><a href="#" class="button">Learn More</a></li> -->
						<!-- </ul> -->
					<!-- </div> -->
					<!-- <a href="#four" class="goto-next scrolly">Next</a> -->
				<!-- </section> -->

			<!-- Four -->
				<!-- <section id="four" class="wrapper style1 special fade-up"> -->
					<!-- <div class="container"> -->
						<!-- <header class="major"> -->
							<!-- <h2>Accumsan sed tempus adipiscing blandit</h2> -->
							<!-- <p>Iaculis ac volutpat vis non enim gravida nisi faucibus posuere arcu consequat</p> -->
						<!-- </header> -->
						<!-- <div class="box alt"> -->
							<!-- <div class="row gtr-uniform"> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									<!-- <span class="icon alt major fa-area-chart"></span> -->
									<!-- <h3>Ipsum sed commodo</h3> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									<!-- <span class="icon alt major fa-comment"></span> -->
									<!-- <h3>Eleifend lorem ornare</h3> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									<!-- <span class="icon alt major fa-flask"></span> -->
									<!-- <h3>Cubilia cep lobortis</h3> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									<!-- <span class="icon alt major fa-paper-plane"></span> -->
									<!-- <h3>Non semper interdum</h3> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									<!-- <span class="icon alt major fa-file"></span> -->
									<!-- <h3>Odio laoreet accumsan</h3> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
								<!-- <section class="col-4 col-6-medium col-12-xsmall"> -->
									<!-- <span class="icon alt major fa-lock"></span> -->
									<!-- <h3>Massa arcu accumsan</h3> -->
									<!-- <p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p> -->
								<!-- </section> -->
							<!-- </div> -->
						<!-- </div> -->
						<!-- <footer class="major"> -->
							<!-- <ul class="actions special"> -->
								<!-- <li><a href="#" class="button">Magna sed feugiat</a></li> -->
							<!-- </ul> -->
						<!-- </footer> -->
					<!-- </div> -->
				<!-- </section> -->

			<!-- Five -->
				<!-- <section id="five" class="wrapper style2 special fade"> -->
					<!-- <div class="container"> -->
						<!-- <header> -->
							<!-- <h2>Magna faucibus lorem diam</h2> -->
							<!-- <p>Ante metus praesent faucibus ante integer id accumsan eleifend</p> -->
						<!-- </header> -->
						<!-- <form method="post" action="#" class="cta"> -->
							<!-- <div class="row gtr-uniform gtr-50"> -->
								<!-- <div class="col-8 col-12-xsmall"><input type="email" name="email" id="email" placeholder="Your Email Address" /></div> -->
								<!-- <div class="col-4 col-12-xsmall"><input type="submit" value="Get Started" class="fit primary" /></div> -->
							<!-- </div> -->
						<!-- </form> -->
					<!-- </div> -->
				<!-- </section> -->

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon alt fa-linkedin"><span class="label">LinkedIn</span></a></li>
						<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
						<li><a href="#" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
					</ul>
					<ul class="copyright">
						<li>SERALE Automaticaciones &copy;. All rights reserved.</li><li>Design: Alex Bermejo </a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
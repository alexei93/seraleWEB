<?php
	
	//Conexion database
	$con = mysqli_connect('localhost','root','');
	//Seleccionamos la base de datos
	mysqli_select_db($con,'arduino');
	//Seleccionamos nuestra peticion (campos especificos)
	//en nuesto caso tenemos los campos:
	/* ID | Objeto | Rele | Valor */
	// $sql = "SELECT * from casa";
	$sql = "SELECT * FROM `casa`";
	// Ejecutamos la peticion
	$resultado = mysqli_query($con,$sql);
	$rows = "";
	while($row = mysqli_fetch_assoc($resultado)) {
		$rows .= json_encode($row);               
    };
	print_r($rows);

	
	
?>
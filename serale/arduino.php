<?php
	
	//Conexion database
	$con = mysqli_connect('localhost','root','');
	//Seleccionamos la base de datos
	mysqli_select_db($con,'arduino');
	//Seleccionamos nuestra peticion (campos especificos)
	//en nuesto caso tenemos los campos:
	/* ID | Objeto | Rele | Valor */
	$sql = "SELECT * from casa";	
	
	
	
	// Ejecutamos la peticion
	// $resultado = mysqli_query($con,$sql);	
	// $row = mysqli_fetch_assoc($resultado);	
	// $aaa = json_encode($row);
	
	$resultado = mysqli_query($con,$sql);
	$aaa = "";
	while($row = mysqli_fetch_assoc($resultado)) {
		$aaa .= json_encode($row) . '<br>';
	
		// print_r($aaa)              
    };
	print_r('_'.$aaa.'_');
	
		
		// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 	$value = $_POST['pIniciales'];
			
		// 	if($value === $aaa){		
		// 		print_r("Son iguales");
		// 	}
		// 	else{
		// 		print_r("Hay cambios");
		// 		// print_r("Iniciales");
		// 		// print_r($value);
		// 		// print_r("Actuales");
		// 		// print_r($aaa);
		// 	}
		// }
		// else{
		// 	print_r($aaa);
		// }
		// mysqli_close($con);
		
		
		
		// echo '<br/>';		
		// print_r("Iniciales:");
		// echo '<br/>';
		// print_r($value);
		// print_r("Actuales:");
		// echo '<br/>';
		// print_r($aaa);
	
?>
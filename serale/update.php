<?php
	//Conexion database
	$con = mysqli_connect('localhost','root','');
	//Seleccionamos la base de datos
	mysqli_select_db($con,'arduino');
	
	
	
	/* Antes de realizar nuestra peticion , vamos a ver de que tipo es para cambiar los datos que necesitamos */
	
	/* SI es de tipo BOOLEAN ----->  Si data nos trae un 1, metemos un 0 y viceversa */
		if ($_POST['pType'] == 'boolean'){
		$_POST['pValor'] = ($_POST['pValor']) ? 0 : 1;
		}
	/* SI ES LA PERSIANA NO TENEMOS QUE HACER NADA ESPECIAL, PORQUE YA NOS VIENE EL VALOR DADO */
	
	//Realizamos nuestra peticion  de update(campos especificos)
	//en nuesto caso tenemos los campos:
	/* ID | Objeto | Rele | Valor */
	
	$sql = "UPDATE casa SET Room='$_POST[pRoom]',Objeto='$_POST[pObjeto]',Rele='$_POST[pRele]',Valor='$_POST[pValor]' WHERE ID=$_POST[pID]";
	
	// Ejecutamos la peticion
		if(mysqli_query($con,$sql))
			// header("refresh:1; url=index.php");
		// else
			// echo "Ha ocurrido un error";
			// header("refresh:1; url=index.php");
		
?>
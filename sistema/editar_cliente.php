	<!-- esta lineas de codigo php valida que el usuario que se esta registrando obligatoriamente rellene todos los campos que son requeridos para crear su usuario -->
<?php 

session_start();

include"../conexion.php";

	if (!empty($_POST))
	 {

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario a guardado
			$idCliente = $_POST['id'];
			$rif 	   = $_POST['rif'];
			$nombre    = $_POST['nombre'];
			$telefono  = $_POST['telefono'];
			$direccion = $_POST['direccion'];
	//con esto verifico que sea numerico el rif y sea diferente de 0
			$result = 0;
			if (is_numeric($rif) AND $rif != 0) {
				
			
	// este query nos permite actualizar el usuario solo si el usuario no existe o el correo no existe o es el mismo
			$query = mysqli_query($conection,"SELECT * FROM cliente 
											  WHERE (rif = '$rif' AND idcliente != $idCliente) ");
	//con esto contamos cuantos registros hay en el array		
			$result = mysqli_fetch_array($query);
			$result = count((array) $result);
		}	
																
	//hago la validacion si el resultado es mayor a 0 me muestra un error de lo contrario me lo manda al $query_insert donde este inserta los valores en los campos que se mencionan	
			if ($result > 0) {
						$alert='<p class="msg_error">el R.I.F ya existe,por favor indique otro.</p>';
					}else{
						if ($rif == '') {
							$rif = 0;
						}
						
						$sql_update= mysqli_query($conection,"UPDATE cliente SET rif = $rif,nombre ='$nombre',telefono ='$telefono', direccion ='$direccion' WHERE idcliente = $idCliente");

				
			if ($sql_update) {
					$alert='<p class="msg_save">Cliente actualizado </p>';			
							}else{
								$alert='<p class="msg_error"> error al actualizar el Cliente</p>';
				}			
					
			}	
		
		}
		
	
	}
/**************************************************************************************************************************/	
//esta lineas me permite mostrar los datos de la pagina editar_usuario.php
//con esta linea validamos que exista el id si no existe nos retorna al menu lista_usuario.php
	if (empty($_GET['id'])) {
		header('location: lista_clientes.php');
		mysqli_close($conection);
	}
	$idcliente = $_GET['id'];
//este query te permite traer los datos de la base de datos para poder editar el cliente seleccionado
	$sql = mysqli_query($conection,"SELECT * FROM cliente  WHERE idcliente=$idcliente AND status = 1");
	

//este me verifica que el idusuario exista si no existe me manda a lista_usuarios.php
	$result_sql = mysqli_num_rows($sql);
	if ($result_sql == 0) {
		header('location: lista_clientes.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {

			$idcliente = $data['idcliente'];
			$rif	   = $data['rif'];
			$nombre    = $data['nombre'];
			$direccion   = $data['direccion'];
			$telefono  = $data['telefono'];			
		}
	}
?>

<!-- /*************************************************************************************************************************/ -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Actualizar Cliente</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1>Actualizar Cliente</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

		<form action="" method="post">
			<label for="rif">R.i.f</label>
			<input type="hidden"  name="id" value="<?php echo $idcliente; ?>">
			<input type="number" name="rif" id="rif" placeholder="numero de rif" value="<?php echo $rif; ?>">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" placeholder="nombre completo" value="<?php echo $nombre; ?>">
			<label for="telefono">Telefono</label>
			<input type="number" name="telefono" id="telefono" placeholder="telefono del cliente" value="<?php echo $telefono; ?>">
			<label for="direccion">Direccion</label>
			<input type="text" name="direccion" id="direccion" placeholder="direccion completa" value="<?php echo $direccion; ?>">
			
			<input type="submit" value="Guardar Clientes" class="btn_save">
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
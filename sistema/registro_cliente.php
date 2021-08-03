	<!-- //esta parte registra los clientes  -->
<?php 
session_start();

include"../conexion.php";

	if(!empty($_POST)) {

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario tiene del cliente
			$rif 		= $_POST['rif'];
			$nombre 	= $_POST['nombre'];
			$telefono   = $_POST['telefono'];
			$direccion  = $_POST['direccion'];
			$usuario_id = $_SESSION['iduser'];

			$result = 0;
	//este if me verifica que el usuario solo pueda poner numeros en el campo "rif" y me lo guarda en el array
			if (is_numeric($rif) AND $rif !=0) {

				$query = mysqli_query ($conection,"SELECT * FROM cliente WHERE rif = '$rif' ");
				$result = mysqli_fetch_array($query);
			}
	//si la busqueda tubo exito significa que hay un campo rif con el mismo dato a lo que salta una alerta si no procede a guarda los datos en los campos del query		
			if ($result > 0) {
				$alert='<p class="msg_error">el Rif ya existe.</p>';
			}else{
				$query_insert = mysqli_query($conection,"INSERT INTO cliente(rif,nombre,telefono,direccion,usuario_id)
														 VALUES('$rif','$nombre','$telefono','$direccion','$usuario_id')");
	//si hubo un error  o no al guardar los datos salta esta alarma		
			if ($query_insert) {
								$alert='<p class="msg_save">su cliente fue guardado satisfactoriamente</p>';			
							}else{
								$alert='<p class="msg_error"> error al guardar su cliente</p>';
				}			
					
			}	
		
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Registro de Clientes</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1><i class="fas fa-user-plus"></i> Registro Cliente</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

		<form action="" method="post">
			<label for="rif">R.i.f</label>
			<input type="number" name="rif" id="rif" placeholder="numero de rif">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" placeholder="nombre completo">
			<label for="telefono">Telefono</label>
			<input type="number" name="telefono" id="telefono" placeholder="telefono del cliente">
			<label for="direccion">Direccion</label>
			<input type="text" name="direccion" id="direccion" placeholder="direccion completa">
			
			<button type="submit" class="btn_save"><i class="far fa-share-square"></i> Crear Cliente</button>
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
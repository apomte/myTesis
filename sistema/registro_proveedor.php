	<!-- //esta parte registra los proveedores  -->
<?php 
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)  {
	header("location: ./");
}

include"../conexion.php";

	if(!empty($_POST)) {

		$alert='';
		if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario tiene del proveedor
			$proveedor 		= $_POST['proveedor'];
			$contacto 		= $_POST['contacto'];
			$telefono   	= $_POST['telefono'];
			$direccion  	= $_POST['direccion'];
			$usuario_id 	= $_SESSION['iduser'];

			
				$query_insert = mysqli_query($conection,"INSERT INTO proveedor 																(proveedor,contacto,telefono,direccion,usuario_id)
														 VALUES('$proveedor','$contacto','$telefono','$direccion','$usuario_id')");
	//si hubo un error  o no al guardar los datos salta esta alarma		
			if ($query_insert) {
								$alert='<p class="msg_save">Proveedo  guardado satisfactoriamente</p>';			
							}else{
								$alert='<p class="msg_error"> error al guardar su Proveedor</p>';
				}			
					
			}	
		
		}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Registro de Proveedores</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1><i class="fas fa-user-plus"></i> Registro Proveedor</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

		<form action="" method="post">
			<label for="proveedor">Proveedor</label>
			<input type="text" name="proveedor" id="proveedor" placeholder="nombre del proveedor proveedor">
			<label for="contacto">Contacto</label>
			<input type="text" name="contacto" id="contacto" placeholder="nombre del contacto">
			<label for="telefono">Telefono</label>
			<input type="number" name="telefono" id="telefono" placeholder="telefono del cliente">
			<label for="direccion">Direccion</label>
			<input type="text" name="direccion" id="direccion" placeholder="direccion completa">
			
			<button type="submit" class="btn_save"><i class="far fa-share-square"></i> Guardar Proveedor</button>
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
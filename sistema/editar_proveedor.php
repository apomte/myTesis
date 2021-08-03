	<!-- esta lineas de codigo php valida que el usuario que se esta registrando obligatoriamente rellene todos los campos que son requeridos para crear su usuario -->
<?php 

session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)  {
	header("location: ./");
}
include"../conexion.php";

	if (!empty($_POST))
	 {

		$alert='';
		if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario a guardado
			$idproveedor = $_POST['id'];
			$proveedor 	   = $_POST['proveedor'];
			$contacto    = $_POST['contacto'];
			$telefono  = $_POST['telefono'];
			$direccion = $_POST['direccion'];	
						
						$sql_update= mysqli_query($conection,"UPDATE proveedor SET proveedor = '$proveedor',contacto ='$contacto',telefono ='$telefono', direccion ='$direccion' WHERE codproveedor = $idproveedor");

				
			if ($sql_update) {
					$alert='<p class="msg_save">Proveedor actualizado </p>';			
							}else{
								$alert='<p class="msg_error"> error al actualizar el Proveedor</p>';
				}			
					
			}	
		
		}
/**************************************************************************************************************************/	
//esta lineas me permite mostrar los datos de la pagina editar_usuario.php
//con esta linea validamos que exista el id si no existe nos retorna al menu lista_usuario.php
	if (empty($_GET['id'])) {
		header('location: lista_proveedores.php');
		mysqli_close($conection);
	}
	$idproveedor = $_GET['id'];
//este query te permite traer los datos de la base de datos para poder editar el cliente seleccionado
	$sql = mysqli_query($conection,"SELECT * FROM proveedor  WHERE codproveedor=$idproveedor AND status = 1");
	

//este me verifica que el idusuario exista si no existe me manda a lista_usuarios.php
	$result_sql = mysqli_num_rows($sql);
	if ($result_sql == 0) {
		header('location: lista_proveedores.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {

			$codproveedor  = $data['codproveedor'];
			$proveedor	   = $data['proveedor'];
			$contacto      = $data['contacto'];
			$telefono      = $data['telefono'];		
			$direccion     = $data['direccion'];
				
		}
	}
?>

<!-- /*************************************************************************************************************************/ -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Actualizar Proveedor</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1>Actualizar Proveedor</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

		<form action="" method="post">
			<input type="hidden" name="id" value="<?php echo $idproveedor?>">
			<label for="proveedor">Proveedor</label>
			<input type="text" name="proveedor" id="proveedor" placeholder="nombre del proveedor proveedor " value="<?php echo $proveedor?>">
			<label for="contacto">Contacto</label>
			<input type="text" name="contacto" id="contacto" placeholder="nombre del contacto"value="<?php echo $contacto?>">
			<label for="telefono">Telefono</label>
			<input type="number" name="telefono" id="telefono" placeholder="telefono del cliente"value="<?php echo $telefono?>">
			<label for="direccion">Direccion</label>
			<input type="text" name="direccion" id="direccion" placeholder="direccion completa"value="<?php echo $direccion?>">
			
			<button type="submit" class="btn_save"><i class="far fa-share-square"></i> Actualizar Proveedor</button>
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
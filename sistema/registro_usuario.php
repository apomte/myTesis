	<!-- esta linea de codigo php valida que el usuario que se esta registrando obligatoriamente rellene todos los campos que son requeridos para crear su usuario -->
<?php 
session_start();
if ($_SESSION['rol'] != 1) {
	header("location: ./");
}

include"../conexion.php";

	if (!empty($_POST))
	 {

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario a guardado
			
			$nombre = $_POST['nombre'];
			$email = $_POST['correo'];
			$user = $_POST['usuario'];
			$clave =  md5($_POST['clave']);
			$rol = $_POST['rol'];
	// en esta verificamos que tanto el usuario y el correo no exitan si existen arrojara un error	
			$query = mysqli_query ($conection,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
			
	//me devuelbe el resultado en un array 
			$result = mysqli_fetch_array($query);
	//hago la validacion si el resultado es mayor a 0 me muestra un error de lo contrario me lo manda al $query_insert donde este inserta los valores en los campos que se mencionan	
			if ($result > 0) {
						$alert='<p class="msg_error">el correo o usuario ya existe.</p>';
					}else{
	// query para insertar datos en la tabla usuario
						$query_insert = mysqli_query($conection,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
					VALUES('$nombre','$email','$user','$clave','$rol')");
	//despues de devolverme un valor nesesito evaluar si es verdadero o no	
			if ($query_insert) {
					$alert='<p class="msg_save">usuario creado</p>';			
							}else{
								$alert='<p class="msg_error"> erro al crear su usuario</p>';
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
	<title> Registro de usuarios</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1><i class="fas fa-user-plus"></i> Registro usuario</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

		<form action="" method="post">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" placeholder="nombre completo">
			<label for="correo">Correo electronico</label>
			<input type="email" name="correo" id="correo" placeholder="correo electronico">
			<label for="usuario">Usuario</label>
			<input type="text" name="usuario" id="usuario" placeholder="usuario">
			<label for="clave">Clave</label>
			<input type="password" name="clave" id="clave" placeholder="clave de acceso">
			<label for="rol">Tipo usuario</label>

			<?php
			// <!-- query para devolver los roles de usuarios -->
				$query_rol = mysqli_query($conection,"SELECT * FROM rol");
				
			// query para contar cuantas filas me esta devolviendo
				$result_rol = mysqli_num_rows($query_rol);
				
			?>
			<!-- //este select me indica mediante opciones que rol le voy a dar al usuario que voy a crear -->
			<select name="rol" id="rol">
			<?php
				if ($result_rol > 0) {
			//este while me cuenta cuantas filas me esta recorriendo el $rol
					while ($rol = mysqli_fetch_array($query_rol)) {
						?>
			<!-- // en el value se va a imprimir lo que me esta devolviendo el id del rol -->
					<option value="<?php echo $rol["idrol"];?>"><?php echo $rol["rol"]?></option>
						<?php
					}
				}
			?>
			</select>
			<button type="submit" class="btn_save"><i class="far fa-share-square"></i> Crear Usuario</button>
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
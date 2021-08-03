	<!-- esta lineas de codigo php valida que el usuario que se esta registrando obligatoriamente rellene todos los campos que son requeridos para crear su usuario -->
<?php 

session_start();
if ($_SESSION['rol'] != 1) {
	header("location: ./");
}

include"../conexion.php";

	if (!empty($_POST))
	 {

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])  || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario a guardado
			$idUsuario = $_POST['idUsuario'];
			$nombre = $_POST['nombre'];
			$email = $_POST['correo'];
			$user = $_POST['usuario'];
			$clave =  md5($_POST['clave']);
			$rol = $_POST['rol'];
	// este query nos permite actualizar el usuario solo si el usuario no existe o el correo no existe o es el mismo
			$query = mysqli_query($conection,"SELECT * FROM usuario
														WHERE (usuario = '$user'  AND idusuario != $idUsuario) 			OR (correo = '$email' AND idusuario != $idUsuario) ");	
	//me devuelbe el resultado en un array 
			$result = mysqli_fetch_array($query);
	//hago la validacion si el resultado es mayor a 0 me muestra un error de lo contrario me lo manda al $query_insert donde este inserta los valores en los campos que se mencionan	
			if ($result > 0) {
						$alert='<p class="msg_error">el correo o usuario ya existe.</p>';
					}else{
	//validacion si el usuario no coloca contraseña para actualizar no se actualiza su contraseña con el siguiente query
					if (empty($_POST['clave'])) {
						
						$sql_update= mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre',correo ='$email', usuario ='$user',rol ='$rol' WHERE idusuario = $idUsuario");

					}else{

						$sql_update= mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre',correo ='$email', usuario ='$user',clave ='$clave' ,rol ='$rol' WHERE idusuario = $idUsuario");

					}	
			if ($sql_update) {
					$alert='<p class="msg_save">usuario actualizado </p>';			
							}else{
								$alert='<p class="msg_error"> error al actualizar su usuario</p>';
				}			
					
			}	
		
		}
		
	
	}
/**************************************************************************************************************************/	
//esta lineas me permite mostrar los datos de la pagina editar_usuario.php
//con esta linea validamos que exista el id si no existe nos retorna al menu lista_usuario.php
	if (empty($_GET['id'])) {
		header('location: lista_usuarios.php');
		mysqli_close($conection);
	}
	$iduser = $_GET['id'];
//este query te permite traer los datos de la base de datos para poder editar el usuario seleccionado
	$sql = mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol from usuario u INNER JOIN rol r on u.rol = r.idrol WHERE idusuario=$iduser AND status = 1");
	

//este me verifica que el idusuario exista si no existe me manda a lista_usuarios.php
	$result_sql = mysqli_num_rows($sql);
	if ($result_sql == 0) {
		header('location: lista_usuarios.php');
	}else{
//si no es igual a 0 me los almacena en este array con los siguientes datos
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {

			$iduser = $data['idusuario'];
			$nombre = $data['nombre'];
			$correo = $data['correo'];
			$usuario = $data['usuario'];
			$idrol = $data['idrol'];
			$rol = $data['rol'];

//con estas lineas configuramos el tipo de rol del usuario cuando le demos a editar
	if ($idrol == 1) {
		$option = '<option value="'.$idrol.'"select>'.$rol.'</option>';
				}else if ($idrol == 2) {
					$option = '<option value="'.$idrol.'"select>'.$rol.'</option>';
				}else if ($idrol == 3) {
						$option = '<option value="'.$idrol.'"select>'.$rol.'</option>';
				}			
		}
	}
?>

<!-- /*************************************************************************************************************************/ -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Actualizar usuarios</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1>Actualizar usuario</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

		<form action="" method="post">
			<input type="hidden" name="idUsuario" value="<?php echo $iduser ;?>">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" placeholder="nombre completo" value="<?php echo $nombre; ?>">
			<label for="correo">Correo electronico</label>
			<input type="email" name="correo" id="correo" placeholder="correo electronico" value="<?php echo $correo; ?>">
			<label for="usuario">Usuario</label>
			<input type="text" name="usuario" id="usuario" placeholder="usuario" value="<?php echo $usuario; ?>">
			<label for="clave">Clave</label>
			<input type="password" name="clave" id="clave" placeholder="clave de acceso">
			<label for="rol">Tipo usuario</label>

			<?php
			
			include"../conexion.php";

			// <!-- query para devolver los roles de usuarios -->
				$query_rol = mysqli_query($conection,"SELECT * FROM rol");
				

			// query para contar cuantas filas me esta devolviendo
				$result_rol = mysqli_num_rows($query_rol);

			?>
			
			<select name="rol" id="rol" class="notITEMone">
			<?php
			//echo me muestra el rol del usuario que  va a ser editado 
				echo $option;

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
			<input type="submit" value="actualizar usuario" class="btn_save">
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
<!-- //mostrar el usuario que queremos eliminar -->
<!-- // con este query eliminamos los datos de la lista de usuarios  -->
<?php 
 
session_start();
if ($_SESSION['rol'] != 1) {
	header("location: ./");
}

include "../conexion.php";

 if (!empty($_POST)) {
 	$idusuario = $_POST['idusuario'];
 	// con este query eliminamos la informacion de la pagina web lista_usuario.php pero mantenemos los registros en la base de datos con la tabla status en 0 que es la que me controla si muestro o no al usuario

 	$query_delete = mysqli_query($conection,"UPDATE usuario SET status = 0  WHERE idusuario =$idusuario");
 	if ($query_delete)
 	 {
 		header("location: lista_usuarios.php");

 		mysqli_close($conection);

 		 	}else{
 		 		echo "Error al eliminar";
 		 	}

 }

/*si la variable id no existe redirecciona a lista_usuario.php ,si existe el id busca en la base de datos conexion.php y lo guarda en la variable $idusuario el dato del id*/

if (empty($_REQUEST['id']) || $_REQUEST['id'] ==1) {
	header("location: lista_usuarios.php");

	mysqli_close($conection);

	}else{
//este query me muestra los datos que voy a borrar en pantalla
		$idusuario = $_REQUEST['id'];
//en este query buscamos solo el nombre , usuario y el rol de las diferentes tablas
		$query = mysqli_query($conection,"SELECT u.nombre,u.usuario,r.rol
											FROM usuario u
											INNER JOIN
											rol r 
											ON u.rol = r.idrol
											WHERE u.idusuario =$idusuario");

		mysqli_close($conection);
		
//guardamos las filas que buscamos en la variable mysqli_fetch_array y la variable $result guarda una dato 0 o 1 que es si el query de arriva tubo exito  		
		$result = mysqli_num_rows($query);
		if ($result > 0) {
			while ($data = mysqli_fetch_array($query)) {
				$nombre  = $data['nombre'];
				$usuario = $data['usuario'];
				$rol 	 = $data['rol'];
			}
		}else{
			header("location: lista_usuarios.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>eliminar usuarios</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Esta seguro de borrar estos Datos?</h2>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Usuario: <span><?php echo $usuario; ?></span></p>
			<p>Tipo de Usuario: <span><?php echo $rol; ?></span></p>
			<form method="post" action="">
				<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
				<a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok">
			</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
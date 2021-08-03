<!-- //mostrar el usuario que queremos eliminar -->
<!-- // con este query eliminamos los datos de la lista de usuarios  -->
<?php 
 
session_start();
if ($_SESSION['rol'] != 1 AND $_SESSION['rol'] != 2) {
	header("location: ./");
}

include "../conexion.php";

 if (!empty($_POST)) {
 	if (empty($_POST)) {

 		header("location: lista_clientes.php");
 		mysqli_close($conection);
 	}

 	$idcliente = $_POST['idcliente'];

 	// con este query eliminamos la informacion de la pagina web lista_clientes.php pero mantenemos los registros en la base de datos con la tabla status en 0 que es la que me controla si muestro o no al usuario

 	$query_delete = mysqli_query($conection,"UPDATE cliente SET status = 0  WHERE idcliente =$idcliente");
 	if ($query_delete)
 	 {
 		header("location: lista_clientes.php");

 		mysqli_close($conection);

 		 	}else{
 		 		echo "Error al eliminar";
 		 	}

 }

/*si la variable id no existe redirecciona a lista_clientes.php ,si existe el id busca en la base de datos conexion.php y lo guarda en la variable $idusuario el dato del id*/

if (empty($_REQUEST['id'])) {
	header("location: lista_clientes.php");

	mysqli_close($conection);

	}else{
//este query me muestra los datos que voy a borrar en pantalla
		$idcliente = $_REQUEST['id'];
//en este query buscamos solo el nombre , usuario y el rol de las diferentes tablas
		$query = mysqli_query($conection,"SELECT * FROM cliente WHERE idcliente =$idcliente");

		mysqli_close($conection);
		
//guardamos las filas que buscamos en la variable mysqli_fetch_array y la variable $result guarda una dato 0 o 1 que es si el query de arriva tubo exito  		
		$result = mysqli_num_rows($query);
		if ($result > 0) {
			while ($data = mysqli_fetch_array($query)) {
				$rif  = $data['rif'];
				$nombre = $data['nombre'];
			}
		}else{
			header("location: lista_clientes.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>eliminar Cliente</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Esta seguro de borrar estos Datos?</h2>
			<p>Nombre del cliente: <span><?php echo $nombre; ?></span></p>
			<p>R.I.F: <span><?php echo $rif; ?></span></p>
			<form method="post" action="">
				<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<a href="lista_clientes.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok">
			</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
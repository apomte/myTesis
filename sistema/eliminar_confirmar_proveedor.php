<!-- //mostrar el usuario que queremos eliminar -->
<!-- // con este query eliminamos los datos de la lista de usuarios  -->
<?php 
 
session_start();
if ($_SESSION['rol'] != 1 AND $_SESSION['rol'] != 2) {
	header("location: ./");
}

include "../conexion.php";

 if (!empty($_POST)) {
 	if (empty($_POST['idproveedor'])) {

 		header("location: lista_proveedor.php");
 		mysqli_close($conection);
 	}

 	$idproveedor = $_POST['idproveedor'];

 	// con este query eliminamos la informacion de la pagina web lista_clientes.php pero mantenemos los registros en la base de datos con la tabla status en 0 que es la que me controla si muestro o no al usuario

 	$query_delete = mysqli_query($conection,"UPDATE proveedor SET status = 0  WHERE codproveedor =$idproveedor");
 	if ($query_delete)
 	 {
 		header("location: lista_proveedores.php");

 		mysqli_close($conection);

 		 	}else{
 		 		echo "Error al eliminar";
 		 	}

 }

/*si la variable id no existe redirecciona a lista_clientes.php ,si existe el id busca en la base de datos conexion.php y lo guarda en la variable $idusuario el dato del id*/

if (empty($_REQUEST['id'])) {
	header("location: lista_proveedores.php");

	mysqli_close($conection);

	}else{
//este query me muestra los datos que voy a borrar en pantalla
		$idproveedor = $_REQUEST['id'];
//en este query buscamos solo el nombre , usuario y el rol de las diferentes tablas
		$query = mysqli_query($conection,"SELECT * FROM proveedor WHERE codproveedor =$idproveedor");

		mysqli_close($conection);
		
//guardamos las filas que buscamos en la variable mysqli_fetch_array y la variable $result guarda una dato 0 o 1 que es si el query de arriva tubo exito  		
		$result = mysqli_num_rows($query);
		if ($result > 0) {
			while ($data = mysqli_fetch_array($query)) {
				$proveedor = $data['proveedor'];
			}
		}else{
			header("location: lista_proveedores.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>eliminar Proveedor</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Esta seguro de borrar estos Datos?</h2>
			|
			<p>Nombre del Proveedor: <span><?php echo $proveedor; ?></span></p>
			<form method="post" action="">
				<input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
				<a href="lista_proveedores.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok">
			</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
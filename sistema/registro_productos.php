	<!-- //esta parte registra los proveedores  -->
<?php 
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)  {
	header("location: ./");
}

include"../conexion.php";

	if(!empty($_POST)) {
	// print_r($_FILES);
	// exit;

		$alert='';
		if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || empty($_POST['cantidad']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario tiene del proveedor
			$proveedor 		= $_POST['proveedor'];
			$producto 		= $_POST['producto'];
			$precio   		= $_POST['precio'];
			$cantidad  		= $_POST['cantidad'];
			$usuario_id 	= $_SESSION['iduser'];

	//como los archivos de imagenes no se pueden guardar con el metodo "post" nesesitamos capturar los datos que son necesarios para poder guardar un archivo
			$foto 		 = $_FILES['foto'];
			$nombre_foto = $foto['name'];
			$type 		 = $foto['type'];
			$url_temp    = $foto['tmp_name'];
    //cuando no se almacene ninguna foto este va a ser creado por defecto
			$imgProducto = 'img_producto.png';
    //con esto le cambiamos el nombre al archivo y le ponemos uno aleatorio
	//validacion si el usuario  coloca una fotografia		
			if ($nombre_foto != '') {
	//esto me lleva a la carpeta donde me  guardara un archivo aleatoria que cree 
				$destino = 'img/uploads/';
	//me genera un nombre aleatorio encriptado utilizando la fecha como generador
				$img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
	//me genera la extension al final del archivo
				$imgProducto = $img_nombre.'.jpg';
	//me concatena las 2 variables quedando algo asi "img/uploads/img_df343f3343fe3.jpg"
				$src = $destino.$imgProducto;

			}
				$query_insert = mysqli_query($conection,"INSERT INTO producto(proveedor,descripcion,precio,existencia,usuario_id,foto)
														 VALUES('$proveedor','$producto','$precio','$cantidad','$usuario_id','$imgProducto')");
	//si hubo un error  o no al guardar los datos salta esta alarma		
			if ($query_insert) {
	//validamos si esta vacio y lo mandamos a la ruta temporal del archivo"$url_temp" y lo mueve a su nuevo destino "$src"
				if ($nombre_foto != '') {
					move_uploaded_file($url_temp,$src);
				}
								$alert='<p class="msg_save">Producto guardado satisfactoriamente</p>';			
							}else{
								$alert='<p class="msg_error"> error al guardar su Producto</p>';
				}			
					
			}	
		
		}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Registro de Productos</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1><i class="fas fa-user-plus"></i> Registro Productos</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
		<!-- //le indicamos que vamos a poder adjuntar imagenes -->
		<form action="" method="post" enctype="multipart/form-data">
<!-- ************************************************************************************************************** -->
			<!-- esta parte me muestra todos los proveedores de forma ordenada -->
			<label for="proveedor">Proveedor</label>
			<?php 
			$query_proveedor = mysqli_query($conection,"SELECT codproveedor,proveedor FROM proveedor  WHERE status = 1 ORDER BY proveedor ASC");

			$result_proveedor = mysqli_num_rows($query_proveedor);

			 ?>

			<select name="proveedor" id="proveedor">
			<?php 

			if ($result_proveedor > 0) {
				while ($proveedor = mysqli_fetch_array($query_proveedor)) {
					

				?>
				<option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
				<?php  	
				}
			}
			 ?>
			 
				
			</select>
			<label for="producto">Producto</label>
			<input type="text" name="producto" id="producto" placeholder="nombre del producto">

			<label for="precio">Precio</label>
			<input type="number" name="precio" id="precio" placeholder="precio del producto">

			<label for="cantidad">Cantidad</label>
			<input type="number" name="cantidad" id="cantidad" placeholder="cantidad de hay en stok">

			<div class="photo">

	<label for="foto">Foto</label>
        <div class="prevPhoto">
        <span class="delPhoto notBlock">X</span>
        <label for="foto"></label>
        </div>
        <div class="upimg">
        <input type="file" name="foto" id="foto">
        </div>
        <div id="form_alert"></div>
</div>
			<button type="submit" class="btn_save"><i class="far fa-share-square"></i> Guardar Producto</button>
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
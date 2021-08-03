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
		if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || empty($_POST['id']) || empty($_POST['foto_actual']) || empty($_POST['foto_remove']))
		{
			$alert='<p class="msg_error">todos los campos son obligatorios.</p>';

		}else{
	// en esta linea se almacenan los datos que el usuario tiene del proveedor
			$codproducto	= $_POST['id'];
			$proveedor 		= $_POST['proveedor'];
			$producto 		= $_POST['producto'];
			$precio   		= $_POST['precio'];
			$imgProducto   = $_POST['foto_actual'];
			$imgRemove		= $_POST['foto_remove'];

	//como los archivos de imagenes no se pueden guardar con el metodo "post" nesesitamos capturar los datos que son necesarios para poder guardar un archivo
			$foto 		 = $_FILES['foto'];
			$nombre_foto = $foto['name'];
			$type 		 = $foto['type'];
			$url_temp    = $foto['tmp_name'];
			$upd = '';
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
	//si el usuario no le da click a eliminar es porq no cambio la foto y no se ejecuta este if
			}else{
				if ($_POST['foto_actual'] != $_POST['foto_remove']) {
					$imgProducto = 'img_producto.png';
				}
			}




				$query_update = mysqli_query($conection,"UPDATE producto 
														 SET descripcion = '$producto', proveedor = $proveedor, precio = $precio, foto = '$imgProducto'		            
														 WHERE codproducto = $codproducto");
	//validacion si el usuario actualizo su foto y es difrente de la foto predeterminada o si el usuario le dio a metodo remove osea la removio se ejecuta la validacion	
			if ($query_update) {

				if (($nombre_foto != '' && ($_POST['foto_actual'] != 'img_producto.png')) || ($_POST['foto_actual'] != $_POST['foto_remove'])) 
				{
						if (is_file('img/uploads/'.$_POST['foto_actual'])) {

							unlink('img/uploads/'.$_POST['foto_actual']);
						}
						
				}
					
	//validamos si esta vacio y lo mandamos a la ruta temporal del archivo"$url_temp" y lo mueve a su nuevo destino "$src"
				if ($nombre_foto != '') {
					move_uploaded_file($url_temp,$src);
				}
								$alert='<p class="msg_save">Producto Actualizado satisfactoriamente</p>';			
							}else{
								$alert='<p class="msg_error"> error al Actualizar su Producto</p>';
				}			
					
			}	
		
		}
/**********************************************************************************************************/
		//validar que el producto no este vacio y exista en la base de datos

		if (empty($_REQUEST['id'])) {
			header("location: lista_productos.php");
			
		}else{

			$id_producto = $_REQUEST['id'];
			if (!is_numeric($id_producto)) {
				header("location: lista_productos.php");
			} 
			//mostrar los datos del producto que se quiera actualizar en pantalla
			$query_producto = mysqli_query($conection,"SELECT p.codproducto,p.descripcion,p.precio,p.foto,pr.codproveedor,pr.proveedor 				FROM producto p 
													   INNER JOIN proveedor pr 
													   ON p.proveedor = pr.codproveedor 
													   WHERE p.codproducto = $id_producto AND p.status = 1");




			$result_producto = mysqli_num_rows($query_producto);


		// compruba que la foto sea la que se coloco y si no tiene no muestra nada

			$foto = '';
			$classremove = 'notBlock';



			if ($result_producto > 0) {
				$data_producto = mysqli_fetch_assoc($query_producto);

				//comprobacion de la foto
				if ($data_producto['foto'] != 'img_producto.png') {
					$classremove = '';
					$foto ='<img id="img" src="img/uploads/'.$data_producto['foto'].'" alt="producto">';
				}
				
			}else{
				header("location: lista_productos.php");
			}
		}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Actualizar Productos</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<div class="form_register">
		<h1><i class="fas fa-user-plus"></i> Actualizar Productos</h1>
		<hr>
		<!-- //muestra la variable $alert si hay algo y  lo imprima -->
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
		<!-- //le indicamos que vamos a poder adjuntar imagenes -->
		<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden"  name="id" value="<?php echo $data_producto['codproducto'];?>">
		<input type="hidden" id="foto_actual"name="foto_actual" value="><?php echo $data_producto['foto'];?>">
		<input type="hidden" id="foto_remove"name="foto_remove" value="> <?php echo $data_producto['foto'];?>">
<!-- 	<************************************************************************************************************** -->
			<!-- esta parte me muestra todos los proveedores de forma ordenada -->
			<label for="proveedor">Proveedor</label>
			<?php 
			$query_proveedor = mysqli_query($conection,"SELECT codproveedor,proveedor FROM proveedor  WHERE status = 1 ORDER BY proveedor ASC");

			$result_proveedor = mysqli_num_rows($query_proveedor);

			 ?>

			<select name="proveedor" id="proveedor" class="notITEMone">
				<option value="<?php echo $data_producto['codproveedor']; ?>" selected><?php echo $data_producto['proveedor']; ?></option>
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
			<input type="text" name="producto" id="producto" placeholder="nombre del producto" value="<?php echo $data_producto['descripcion'];?>">

			<label for="precio">Precio</label>
			<input type="number" name="precio" id="precio" placeholder="precio del producto" value="<?php echo $data_producto['precio'];?>">

			<div class="photo">

	<label for="foto">Foto</label>
        <div class="prevPhoto">
        <span class="delPhoto <?php echo $classremove ;?>">X</span>
        <label for="foto"></label>
        <?php echo $foto ;?>
        </div>
        <div class="upimg">
        <input type="file" name="foto" id="foto">
        </div>
        <div id="form_alert"></div>
</div>
			<button type="submit" class="btn_save"><i class="far fa-share-square"></i> Actualizar Producto</button>
		</form>
		</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
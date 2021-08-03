
<?php
include "../conexion.php";
session_start();
// print_r($_POST);exit;
//extrae los datos del producto a la hora de agregar
if (!empty($_POST)) {
	if ($_POST['action'] == 'infoproducto') {
		$producto_id = $_POST['producto'];
		$query = mysqli_query($conection,"SELECT codproducto,descripcion FROM producto
										  WHERE codproducto = $producto_id AND status = 1");
		$result = mysqli_num_rows($query);
		if ($result > 0) {
			$data = mysqli_fetch_assoc($query);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);//me codifica la variable $data en formato json y me devuelve la informacion sin caracteres especiales
			exit;
		}
		echo 'error';
		exit;
	}

//este agrega los productos a la tabla entradas
	if ($_POST['action'] == 'addProduct') {

		if (!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto'])) {
			
			$cantidad = $_POST['cantidad'];
			$precio = $_POST['precio'];
			$producto_id = $_POST['producto_id'];
			$usuario_id = $_SESSION['iduser'];

			$query_insert = mysqli_query($conection,"INSERT INTO entradas (codproducto,cantidad,precio,usuario_id) 								  VALUES ($producto_id,$cantidad,$precio,$usuario_id )");

			//ejecutar el procedimiento de almacenado que ya esta en la base de datos
			if ($query_insert) {
				$query_upd = mysqli_query($conection,"CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
				$result_pro = mysqli_num_rows($query_upd);
				if ($result_pro > 0) {
					$data = mysqli_fetch_assoc($query_upd);
					//agregamos al formato json el id 
					$data['producto_id'] = $producto_id;
					echo json_encode($data,JSON_UNESCAPED_UNICODE);//me codifica la variable $data en formato json y me devuelve la informacion sin caracteres especiales
					exit;

					}
				}else{
					echo 'error';
				}

			}else{
			echo 'error';
			exit;
		}

	  }

/*************eliminar productos********************/
if ($_POST['action'] == 'delProduct') {

 	if (empty ($_POST['producto_id']) || !is_numeric($_POST['producto_id'])) {
 		echo 'error';
 	}else{
	$idproducto = $_POST['producto_id'];
 	$query_delete = mysqli_query($conection,"UPDATE producto SET status = 0  WHERE codproducto =$idproducto");
 	if ($query_delete)
 	 {
 		echo 'ok';

 		 	}else{
 		 		echo "Error al eliminar";
 		 	}
 		 }
 		 
	}

	exit;
	}
exit;
?>
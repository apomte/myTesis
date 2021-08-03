
<?php
	
	session_start();

	include"../conexion.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Lista de Productos</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<h1>Lista de Productos</h1>
		<a href="registro_productos.php" class="btn_new">Crear Productos</a>
		<!-- //esta parte es la del buscador en lista de clientes -->
		<form action="buscar_productos.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
			<input type="submit" value="buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Descripcion</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>
				<!-- esta parte me muestra todos los proveedores de forma ordenada -->
			<label for="proveedor"></label>
			<?php 
			$query_proveedor = mysqli_query($conection,"SELECT codproveedor,proveedor FROM proveedor  WHERE status = 1 ORDER BY proveedor ASC");

			$result_proveedor = mysqli_num_rows($query_proveedor);

			 ?>

			<select name="proveedor" id="search_proveedor">
			<option value="" selected>PROVEEDORES</option>
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
				</th>
				<th>Foto</th>
				<th>Acciones</th>
			</tr>
			<?php
			/*paginador de la lista de usuarios*/
			//este query me selecciona todos los registro de la tabla  "Cliente" a modo de contador donde los usuarios con status 1 son los que cuenta
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM producto WHERE status = 1");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
			//esta variable me indica cuantas datos voy a mostrar 
			$por_pagina = 5;

			if (empty($_GET['pagina'])) {
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}
			//la variable desde me almacena la cantidad de registros que va a mostrar en la pagina que seleccionemos
			$desde = ($pagina-1) * $por_pagina;
			//total_paginas sirve para mostrarme el total de paginas del paginador dependiendo siempre de cuantos registros se ecneuntren en la base de datos
			//la funcion ceil redondea una cifra para saber cuantas paginas vamos a mostrar
			$total_paginas = ceil($total_registro / $por_pagina);

			//query para mostrar todos los campos de la tabla cliente
			$query = mysqli_query($conection,"SELECT p.codproducto,p.descripcion,p.precio,p.existencia,pr.proveedor,p.foto FROM producto p 
								 INNER JOIN proveedor pr 
								 ON p.proveedor = pr.codproveedor
											  WHERE p.status = 1 ORDER BY p.codproducto DESC LIMIT $desde,$por_pagina");
			
			mysqli_close($conection);

			/*aqui se guarda el resultado si hay registro procede a mostrar los datos mientras allan datos dentro del array */
			$result = mysqli_num_rows($query);
			if ($result > 0) {
				while ($data = mysqli_fetch_array($query)) {
				if ($data['foto'] != 'img_producto.png') {
					$foto = 'img/uploads/'.$data['foto'];
				}else{
					
					$foto = 'img/'.$data['foto'];
				}
		?>

			<tr class="row<?php echo $data["codproducto"]; ?>"><!-- concatena los id del coproducto  -->
				<td><?php echo $data["codproducto"]; ?></td>
				<td><?php echo $data["descripcion"]; ?></td>
				<td class="cell_precio"><?php echo $data["precio"]; ?></td>
				<td class="cell_existencia"><?php echo $data["existencia"]; ?></td>
				<td><?php echo $data["proveedor"]; ?></td>
				<td class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data["descripcion"]; ?>" > </td>
				<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
				<td>
				
			 <!-- //esta parte me envia desde la lista usuario a un panel editar donde puedo modificar informacion -->
					

					<a class="link_add addproduct" product="<?php echo $data["codproducto"]; ?>" href="#"><i class="fas fa-plus"></i> Agregar</a>
					|
					<a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-edit"></i> Actualizar</a>
					|	
					<a class="link_delete del_producto" href="#" product="<?php echo $data["codproducto"]; ?>"><i class="fas fa-trash-alt"></i> borrar</a>
					<!-- clase de la accion jjavascript de borrar -->
			</td>
			<?php }  ?>

			</tr>
			<?php
			
				}
			}
		?>
		</table>
			<!-- paginador de la lista de usuarios -->
			<div class="paginador">
				<ul>
					<?php
					if ($pagina !=1) {
						
					
					?>
				<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
				<?php
					}
				for ($i=1; $i <=$total_paginas ; $i++) { 
					
					if ($i ==$pagina) {
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
					
				}
				if ($pagina !=$total_paginas) {
					
				
				?>
				
				
				<li><a href="?pagina=<?php echo $pagina+1; ?>"><i class="fas fa-forward"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas;?>"><i class="fas fa-step-forward"></i></a></li>

				<?php  } ?>

				</ul>
			</div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
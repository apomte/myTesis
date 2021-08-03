
<?php
	
	session_start();

	include"../conexion.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Lista de Clientes</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<h1>Lista de Clientes</h1>
		<a href="registro_cliente.php" class="btn_new">Crear Cliente</a>
		<!-- //esta parte es la del buscador en lista de clientes -->
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
			<input type="submit" value="buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>R.I.F</th>
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Direccion</th>
				<th>Acciones</th>
			</tr>
			<?php
			/*paginador de la lista de usuarios*/
			//este query me selecciona todos los registro de la tabla  "Cliente" a modo de contador donde los usuarios con status 1 son los que cuenta
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM cliente WHERE status = 1");
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
			$query = mysqli_query($conection,"SELECT * FROM cliente  
											  WHERE status = 1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina");
			
			mysqli_close($conection);

			/*aqui se guarda el resultado si hay registro procede a mostrar los datos mientras allan datos dentro del array */
			$result = mysqli_num_rows($query);
			if ($result > 0) {
				while ($data = mysqli_fetch_array($query)) {
			//si el campo "rif" es igual a 0 me pone las siglas S/N( sin rif) de otra forma me muestra el valor del capo "rif"
					if ($data["rif"] == 0) {
						
						$rif = 'S/R';
					}else{
						$rif = $data["rif"];
					}
				?>	

			<tr>
				<td><?php echo $data["idcliente"]; ?></td>
				<td><?php echo $rif; ?></td>
				<td><?php echo $data["nombre"]; ?></td>
				<td><?php echo $data["telefono"]; ?></td>
				<td><?php echo $data["direccion"]; ?></td>
				<td>
			<!-- /*esta parte me envia desde la lista usuario a un panel editar donde puedo modificar informacion*/ -->
					<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-edit"></i> editar</a>
					<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
						
					
					|
					
					<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>" ><i class="fas fa-trash-alt"></i> borrar</a>
					<?php }  ?>
			</td>
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
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
		<!-- esta parte es la encargadar de ejecutar el modulo buscar_cliente.php -->
		<?php
		//strtolower esta funcion convierte en minusculas lo que nosotros enviamos
		$busqueda = strtolower($_REQUEST['busqueda']);
		if (empty($busqueda)) {
			header("location: lista_clientes.php");

			mysqli_close($conection);
		}


		?>


		<h1>Lista de Clientes</h1>
		<a href="registro_usuario.php" class="btn_new">Crear Clientes</a>
		<!-- //esta parte es la del buscador en lista de usuarios -->
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
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
			/*buscador de la lista de clientes*/

			//este query me selecciona todos los registro de la tabla  "CLIENTE" que coicidan con la busqueda que hacemos
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM cliente 																		WHERE ( idcliente LIKE '%$busqueda%' OR																		rif       LIKE '%$busqueda%' OR 																	nombre	  LIKE '%$busqueda%' OR 																	telefono  LIKE '%$busqueda%' OR																		direccion LIKE '%$busqueda%' )				 																  AND status = 1");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];




			/*******************************************************************************************************/
			//esta parte del codigo valida el numero de la pagina cuando hacemos click
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

			/*query para filtrar los usuarios y buscarlos*/
			$query = mysqli_query($conection,"SELECT * FROM cliente WHERE ( idcliente LIKE '%$busqueda%' OR											 							rif		  LIKE '%$busqueda%' OR 																	nombre    LIKE '%$busqueda%' OR 										    						telefono  LIKE '%$busqueda%' OR 																	direccion LIKE '%$busqueda%'   )																			  AND  	status = 1 															   ORDER BY idcliente ASC LIMIT $desde,$por_pagina");

			mysqli_close($conection);
			
			/*aqui se guarda el resultado si hay registro */
			$result = mysqli_num_rows($query);
			if ($result > 0) {
				while ($data = mysqli_fetch_array($query)) {
				?>	

			<tr>
				<td><?php echo $data["idcliente"]; ?></td>
				<td><?php echo $data["rif"]; ?></td>
				<td><?php echo $data["nombre"]; ?></td>
				<td><?php echo $data["telefono"]; ?></td>
				<td><?php echo $data["direccion"]; ?></td>
				<td>
			<!-- /*esta parte me envia desde la lista usuario a un panel editar donde puedo modificar informacion*/ -->
			<!-- el codigo de php me crea un superusuario que no puede ser borrado de la lista de usuarios -->
					<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>">editar</a>
					
					<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
					|
					<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>" >borrar</a>
				<?php } ?>
			</td>
			</tr>
			<?php
			
				}
			}
		?>
		</table>
		<!-- //paginador de la busqueda de usuarios -->
		<?php

			if ($total_registro != 0) {
				
		?>
			<!-- paginador de la lista de usuarios -->
			<div class="paginador">
				<ul>
					<?php
					if ($pagina !=1) {
						
					
					?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
				<?php
					}
				for ($i=1; $i <=$total_paginas ; $i++) { 
					
					if ($i ==$pagina) {
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
					
				}
				if ($pagina !=$total_paginas) {
					
				
				?>
				
				
				<li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas;?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>

				<?php  } ?>

				</ul>
			</div>
	<?php  } ?>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>
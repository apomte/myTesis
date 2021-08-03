<?php
	
session_start();
if ($_SESSION['rol'] != 1) {
	header("location: ./");
}

	include"../conexion.php"


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php";?>
	<title>Lista de Usuarios</title>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<!-- esta parte es la encargadar de ejecutar el modulo buscar_usuario.php -->
		<?php
		//strtolower esta funcion convierte en minusculas lo que nosotros enviamos
		$busqueda = strtolower($_REQUEST['busqueda']);
		if (empty($busqueda)) {
			header("location: lista_usuarios.php");

			mysqli_close($conection);
		}


		?>


		<h1>Lista de Usuarios</h1>
		<a href="registro_usuario.php" class="btn_new">Crear Usuarios</a>
		<!-- //esta parte es la del buscador en lista de usuarios -->
		<form action="buscar_usuario.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Correo</th>
				<th>usuario</th>
				<th>Rol</th>
				<th>Acciones</th>
			</tr>
			<?php
			/*buscador de la lista de usuarios*/
			// por medio de la variable "busqueda" cumple la funcion de encontrarpor medio de los nombres claves que serian administrador,supervisor,vendedor,me trae todos los campos que yo escribi y me los muestra en el buscador
			$rol = '';
			if ($busqueda == 'administrador') {

				$rol = "OR rol LIKE '%1%'";

			}elseif ($busqueda == 'supervisor') {

				$rol = "OR rol LIKE '%2%'";

			}elseif ($busqueda == 'vendedor') {

				$rol = "OR rol LIKE '%3%'";
				
			}
			//este query me selecciona todos los registro de la tabla  "Usuario" aque coincidad con la busqueda que hacemos
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM usuario 																						WHERE (   idusuario LIKE '%$busqueda%' OR																				 nombre LIKE '%$busqueda%' OR 																			correo	LIKE '%$busqueda%' OR 																			usuario LIKE '%$busqueda%' 																				$rol	)				 																			AND status = 1");
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
			$query = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol 												  FROM usuario u INNER JOIN rol r ON u.rol = r.idrol 
											  WHERE ( u.idusuario LIKE '%$busqueda%' OR									u.nombre    LIKE '%$busqueda%' OR 								u.correo    LIKE '%$busqueda%' OR 								u.usuario   LIKE '%$busqueda%' OR 								r.rol	    LIKE '%$busqueda%'   )  										AND status = 1 													ORDER BY u.idusuario ASC LIMIT $desde,$por_pagina");

			mysqli_close($conection);
			
			/*aqui se guarda el resultado si hay registro */
			$result = mysqli_num_rows($query);
			if ($result > 0) {
				while ($data = mysqli_fetch_array($query)) {
				?>	

			<tr>
				<td><?php echo $data["idusuario"]; ?></td>
				<td><?php echo $data["nombre"]; ?></td>
				<td><?php echo $data["correo"]; ?></td>
				<td><?php echo $data["usuario"]; ?></td>
				<td><?php echo $data["rol"]; ?></td>
				<td>
			<!-- /*esta parte me envia desde la lista usuario a un panel editar donde puedo modificar informacion*/ -->
			<!-- el codigo de php me crea un superusuario que no puede ser borrado de la lista de usuarios -->
					<a class="link_edit" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>">editar</a>
					<?php
					if ($data['idusuario'] !=1){ ?>
					|
					<a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data["idusuario"]; ?>" >borrar</a>
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
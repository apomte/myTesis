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
		<h1><i class="fas fa-users"></i> Lista de Usuarios</h1>
		<a href="registro_usuario.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear Usuarios</a>
		<!-- //esta parte es la del buscador en lista de usuarios -->
		<form action="buscar_usuario.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
			<button type="submit" class="btn_search"><i class="fas fa-search-plus"></i></button>
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
			/*paginador de la lista de usuarios*/
			//este query me selecciona todos los registro de la tabla  "Usuario" a modo de contador donde los usuarios con status 1 son los que cuenta
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM usuario WHERE status = 1");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
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

			/*query para mostrar de la tabla usuario :idusuario,nombre,correo y de la tabla rol el nombre del rol que esta asociado a la tabla usuario*/
			$query = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE status = 1 ORDER BY u.idusuario ASC LIMIT $desde,$por_pagina");
			
			mysqli_close($conection);

			/*aqui se guarda el resultado si hay registro */
			$result = mysqli_num_rows($query);
			if ($result > 0) {
				while ($data = mysqli_fetch_array($query)) {
				?>	

			<tr class="tr_same">
				<td><?php echo $data["idusuario"]; ?></td>
				<td><?php echo $data["nombre"]; ?></td>
				<td><?php echo $data["correo"]; ?></td>
				<td><?php echo $data["usuario"]; ?></td>
				<td><?php echo $data["rol"]; ?></td>
				<td>
			<!-- /*esta parte me envia desde la lista usuario a un panel editar donde puedo modificar informacion*/ -->
			<!-- el codigo de php me crea un superusuario que no puede ser borrado de la lista de usuarios -->
					<a class="link_edit" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>"><i class="fas fa-edit"></i> editar</a>
					<?php
					if ($data['idusuario'] !=1){ ?>
					|
					<a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data["idusuario"]; ?>" ><i class="fas fa-trash-alt"></i> borrar</a>
				<?php } ?>
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
				<li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><i class="fas fa-backward"></i></a></li>
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
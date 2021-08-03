<!-- este es el sistema de navegacion de la pagina -->
<nav>
			<ul>
				<li><a href="../sistema"><i class="fas fa-home"></i> Inicio</a></li>
				<?php
						if ($_SESSION['rol'] == 1) {	
						?>

				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Usuarios</a>
					<ul>
				
						<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Clientes</a>
					<ul>
						<li><a href="registro_cliente.php"><i class="fas fa-user-plus"></i> Nuevo Cliente</a></li>
						<li><a href="lista_clientes.php"><i class="fas fa-users"></i> Lista de Clientes</a></li>
					</ul>
				</li>
				<li class="principal">
					<?php
						if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {	
						?>
					<a href="#"><i class="fas fa-truck-moving"></i> Proveedores</a>
					
					<ul>
						<li><a href="registro_proveedor.php">Nuevo Proveedor</a></li>
						<li><a href="lista_proveedores.php">Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="principal">
					<a href="#">Productos</a>
					<ul>
						<li><a href="registro_productos.php">Nuevo Producto</a></li>
						<li><a href="lista_productos.php">Lista de Productos</a></li>
					</ul>
				</li>
				<li class="principal">
					<?php
						if ($_SESSION['rol'] == 1) {
							
						?>
					<a href="#">Facturas</a>
					<ul>
						<li><a href="#">Nuevo Factura</a></li>
						<li><a href="#">Facturas</a></li>
					</ul>
					
				</li>
				<?php } ?>
			</ul>
		</nav>
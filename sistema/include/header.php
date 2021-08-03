<?php 
//hace privada la pagina para que no se pueda entrar con un link de la pagina

	if (empty($_SESSION['active'])) {
		
		header('location:../');
		}
?>
<!--es el encabesado de la pagina que se muestra -->
<header>
		<div class="header">
			
			<h1>Sistema de facturacion e inventario</h1>
			<div class="optionsBar">
				<p>venezuela,<?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['user'].' -'.$_SESSION['rol']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include "nav.php"; ?>
	</header>
	<!-- //seccion del modal de javascript -->
	<div class="modal">
		<div class="body_modal">	
		</div>
	</div>

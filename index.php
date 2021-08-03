<!-- //esta es la parte del login que se encarga de verificar los datos  -->
<?php
			//esta variable me emite una alerta cuando el usuario a dado click en ingresar
	$alert = ''; 
			//esto me inicia la sesion	
	session_start();
	if (!empty($_SESSION['active'])) {
		
		header('location:sistema/');
		}else{

	if (!empty($_POST)) {//esta linea me indica que el usuario le a dado click en ingresar
	if (empty($_POST['usuario']) || empty($_POST['clave'])) {
			//me emite una alerta si esta vacios los campos "usuario" y "clave"
				$alert = 'ingrese su usuario y contraseña';
		}else {
			//me conepta a la base de datos y me los guarda en las 2 variables
			require_once "conexion.php";
			// la funcion md5 me permite encriptar la informacion de la base de datos
				$user = mysqli_real_escape_string($conection,$_POST['usuario']);
				$pass =  md5 (mysqli_real_escape_string($conection,$_POST['clave']));
			//esta es el query de verificacion me toma toda la fila en la base de datos de la tabla usuario y clave y me dice si es igual las las variable user y clave
				$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario= '$user' AND clave = '$pass' AND status = 1");
				mysqli_close($conection);
			//esta variable guarda un valor si el query tubo exito en su ejecucion
				$result = mysqli_num_rows($query);
			//si encuentra un valor mayor a 0 se guarda en un array el la variable data 
	if ($result > 0) {
				$data =mysqli_fetch_array($query);
			//esto son las sesiones ya inciciadas por el usuario los $_SESSION son las variables donde los $data que son los campos de la base de datos se van a guardar
				$_SESSION['active']= true;
				$_SESSION['iduser']= $data['idusuario'];
				$_SESSION['nombre']= $data['nombre'];
				$_SESSION['user']= $data['usuario'];
				$_SESSION['rol']= $data['rol'];
			//todo estos datos se redireccionan al header que nos mandaria si todo sale bien a la carpeta sistema  y nos manda un mensaje $alert si algo malo ocurrio	
		header('location:sistema/');
		}else{
				$alert = 'el usuario o la clave es incorrecto';
			//esto finaliza la sesion una ves finalizada
		session_destroy();
			}
		}
	}
}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login | Sistema de control de inventario</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
	<section id="container">
	<form action="" method="post">
	<h3>inciar sesion</h3>
	<img src="img/login.png">
	<input type="text" name="usuario" placeholder="Usuario">
	<input type="password" name="clave" placeholder="Contraseña">
	<!-- //indicamos que nos imprimma -->
	<div class="alert"><?php echo isset($alert) ? $alert:'';  ?></div>
	<input type="submit" value="INGRESAR">
	</form>
	</section>
</body>
</html>
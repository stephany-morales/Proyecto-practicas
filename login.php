<html>
<head>
	<title>Universidad de Andalucia</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link  rel="stylesheet" href="diseno.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<body style="background-image:url('uni.jpg');background-repeat: no-repeat;background-size: cover;"><!--Imagen de fondo-->
<div class="container h-100">
<div class="d-flex justify-content-center h-100">
			<div class="user_card"><!--Cuadro de datos ingreso de datos-->
				<div class="d-flex justify-content-center">
					<!--Logo-->
					<div class="brand_logo_container">
					<img src="UNIA.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form action="login.php" method="POST">
					<!--Usuario y contraseña-->
					<div class="input-group mb-3">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="number" id="codigo" name="codigo" class="form-control input_user" min="0" max="999999" placeholder="Codigo colaborador" required>
					</div>
					<div class="input-group mb-2">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" id="contra" name="contra" class="form-control input_pass" placeholder="Contraseña" required>
					</div>
					<div class="d-flex justify-content-center mt-3 login_container">
						<input type="submit" value="Login" name="btingreso" class="btn login_btn">
					</div><br>
					<!--Datos para ingresar>
					<h4>codigo 1111 y contra abc123</h4><p>Instalar la nuevo archivo .sql para que funcione bien</p-->
    </form>
	
	</div>
	</div>
</div>
</div>
					
<?php
	include('conectar.php'); //Conexion a base de datos
	if(isset($_POST["btingreso"]))
	{
		//usuario y contraseña
		$codigo = $_POST["codigo"];
		$contra = $_POST["contra"];
		//buscar usuario
		$sql = "SELECT `codigo_colaborador`, `nombres`, `apellidos`,`puesto`, 
		`contrasena`,`codigo_comision`FROM `personal` WHERE `codigo_colaborador`='$codigo' AND `contrasena`='$contra'";
		$result = $conn->query($sql);
		if($result->num_rows == 1)
		{
			$datos = $result->fetch_assoc();
			$puesto = $datos["puesto"];
			$nombre = $datos["nombres"]." ".$datos["apellidos"];
			session_start();
			$_SESSION['codigo'] = $codigo;
			$_SESSION['nombre'] = $nombre;
			$_SESSION['puesto'] = $puesto;
			$_SESSION['codcom'] = $datos["codigo_comision"];
			//dar permisos segun puesto
			if($puesto == 'Administrador')
			{
				header ("Location: registro.php");
			} else 
			{
				header ("Location: facturas.php");
			}
			
		}
		else
		{
			echo '<script type="text/javascript">
			alert("Usuario o contraseña incorrecto");
			</script>';
		}
	}
?>
</body>
</html>
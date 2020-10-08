<html>
<head>
	<title>Universidad de Andalucia</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link  rel="stylesheet" href="diseno.css">
	
</head>
<body>
<style>
body {
	background-image:url('u.jpg');
	background-repeat: no-repeat;
	background-size: cover;
}
div.scrollmenu {
	top: 0;
	position: sticky;
	width: 100%;
  background-color: #AA1A1A;
  overflow: auto;
  white-space: nowrap;
}

div.scrollmenu a {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px;
  text-decoration: none;
}

div.scrollmenu a:hover {
  background-color: #000000;
}

</style>
<div class="scrollmenu">
		<!--Logo y datos del usuario-->
		<a class="navbar-brand" href="#"><img src="UNIA.png" height="35" width="55">   <?php
		session_start();
		echo $_SESSION['nombre']," (",$_SESSION['codigo'],")"; ?>
	</a>
	<!--Opciones del menu-->
		<a href="registro.php" >Registro personal</a>
		<a href="comisiones.php">Ingreso comisiones</a>
		<a href="reportes.php">Reportes</a>
		<!--Salida-->
		<a href="login.php" style="float:right">Salir</a>
	</div>
	
	
<div class="container rounded" style="background-color:FEF8F8">
	
	<h1 class="display-1 mt-4 text-center" style="align:center">Registro Personal</h1><br>
	<form action="registro.php" method="POST" >
	<!--Parte visual--> 
	<div class="row">
		<div class="form-group col-md-3">
			<label for="codcol"><b>Código Colaborador</b></label>
			<input type="number" id="codcol" class="form-control" name="codcol" min="1" max="999999" placeholder="Codigo colaborador" required>
		</div>	
		<div class="form-group col-md-5">
			<label for="nombres"><b>Nombres</b></label>
			<input type="text" id="nombres" name="nombres" class="form-control" placeholder="Nombres" maxlength="50" required>
		</div>	
		<div class="form-group col-md-4">
			<label for="apellidos"><b>Apellidos</b></label>
			<input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" maxlength="30" required>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-3">
			<label for="dpi"><b>No. DPI</b></label>
			<input type="number" id="dpi" name="dpi" class="form-control" placeholder="No. DPI" min="1000000000101" max="9999999999999" required>
		</div>	
		<div class="form-group col-md-4">	
			<label for="fecha"><b>Fecha de Nacimiento</b></label>
			<input type="date" id="fecha" class="form-control" name="fecha" required>
		</div>	
		<div class="form-group col-md-5">	
			<label for="puesto"><b>Puesto</b></label>	
			<select id="puesto" name="puesto" placeholder="Puesto" class="form-control" required>
				<option value="Administrador" >Administrador</option>
				<option value="Coordinador" >Coordinador</option>
				<option value="Docente" >Docente</option>
			</select>
		</div>	
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="contra"><b>Contraseña</b></label>
			<input type="password" class="form-control" id="contra" name="contra" placeholder="Contraseña" required>
		</div>	
		<div class="form-group col-md-4">
			<label for="codcom"><b>Código Comisión</b></label>	
			<input type="number" class="form-control" id="codcom" name="codcom" min="1" max="999999" placeholder="Codigo comision" required>
		</div>	
		<div class="form-group col-md-4">
			<label for="presu"><b>Presupuesto</b></label>
			<input type="number" class="form-control" id="presu" name="presu" min="0.01" max="99999999.99" step="0.01" placeholder="Presupuesto" disabled>
		</div>
	</div>	
		<script>
		//Funcion para habilitar o deshabilitar segun puesto extraida de internet
			$(function() {
				$("#puesto").change( function() {
					if ($(this).val() === "Docente") 
					{
						$("#presu").prop("disabled", false);
					}
					else {
						$("#presu").prop("disabled", true);
					}
				});
			});
		</script>
	<div class="row">	
		<div class="form-group col-md-12">
			<input type="submit" class="btn btn-danger form-control" value="Ingresar" name="bting">
		</div>
	</div>	
	</form>
</div>	

	<?php
	include('conectar.php'); //conexion a base de datos
		if(isset($_POST["bting"]))
		{
			//datos
			$codcol = $_POST["codcol"];
			$nombres = $_POST["nombres"];
			$apellidos = $_POST["apellidos"];
			$dpi = $_POST["dpi"];
			$fecha = $_POST["fecha"];
			$puesto = $_POST["puesto"];
			if($puesto == "Docente")//Solo cuando sea docente va a tener diferente a 0 em presupuesto
			{
				$presu = $_POST["presu"];
			} else
			{
				$presu = 0;
			}
			$contra = $_POST["contra"];
			$codcom = $_POST["codcom"];
			//verificacion de comision
			$com = "SELECT `codigo_comision` FROM `comisiones` WHERE `codigo_comision`='$codcom'";
			if(($conn->query($com))->num_rows == 1)
			{//insercion de datos
			$sql = "INSERT INTO `personal`(`codigo_colaborador`, `nombres`, `apellidos`, 
			`DPI`, `fechadenacimiento`, `puesto`, `presupuesto`, `contrasena`, `codigo_comision`) VALUES 
			('$codcol','$nombres','$apellidos','$dpi','$fecha','$puesto','$presu','$contra','$codcom')";
			if($conn->query($sql))
			{
				echo '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Ingreso de datos exitoso!</strong>
					</div>';
			} else
			{
				echo '<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Error en ingreso de datos! </strong>'.$conn->error.'
					</div>';
			}
			}else{
				echo '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>La comisión no existe!</strong>
					</div>';
			}
		}
	?>
</body>
</html>
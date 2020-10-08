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
	background-image:url('uanda.jpg');
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
		<!--salida-->
		<a href="login.php" style="float:right">Salir</a>
	</div>
	
	
<div class="container rounded" style="background-color:FEF8F8">
	
	<h1 class="display-1 mt-4 text-center" style="align:center">Registro Comisiones</h1><br>
	<!-- Parte visual-->
	<form action="comisiones.php" method="POST">
	<div class="row">
		<div class="form-group col-md-3">		
			<label for="codcom"><b>Código Comisión</b></label>
			<input type="number" class="form-control" min="1" max="999999" id="codcom" name="codcom" placeholder="Codigo comision" required>
		</div>	
		<div class="form-group col-md-5">
			<label for="nomcom"><b>Nombre Comisión</b></label>
			<input type="text" class="form-control" maxlength="20" id="nomcom" name="nomcom" required>
		</div>	
		<div class="form-group col-md-4">
			<label for="presu"><b>Presupuesto Asignado</b></label>
			<input type="number" class="form-control" id="presu" name="presu" min="0"step="0.01" required>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-12">
			<label for="objetivo"><b>Objetivo</b></label>
			<textarea class="form-control" rows="3" id="objetivo" name="objetivo" required></textarea>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-5">	
			<label for="areag"><b>Área Geográfica</b></label>
			<input type="text" class="form-control" id="areag" name="areag" maxlength="30" placeholder="Área geográfica" required>
		</div>	
		<div class="form-group col-md-3">
			<label for="codcoo"><b>Codigo Coordinador</b></label>
			<input type="number" class="form-control" min="1" max="999999" id="codcoo" name="codcoo" placeholder="Codigo coordinador" required>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-12">	
		<input type="submit" class="btn btn-danger form-control" name="btcomi" value="Ingresar">
		</div>
	</div>	
	</form>
	</div>
	<?php
	include('conectar.php'); //conexion base de datos
		if(isset($_POST["btcomi"]))
		{
			//datos
			$codcom = $_POST["codcom"];
			$nomcom = $_POST["nomcom"];
			$presu = $_POST["presu"];
			$objetivo = $_POST["objetivo"];
			$areag = $_POST["areag"];
			$codcoo = $_POST["codcoo"];
			//verificacion exitencia de comision
			$com = "SELECT `codigo_comision`, `nombre_comision` FROM `comisiones` WHERE `codigo_comision`='$codcom' OR `nombre_comision`='$nomcom'";
			if(($conn->query($com))->num_rows == 0)
			{
			//insercion de m=nueva comision
			$sql = "INSERT INTO `comisiones`(`codigo_comision`, `nombre_comision`, `presupuesto`, 
			`objetivo`, `area_geografica`, `codigo_coordinador`)VALUES ('$codcom','$nomcom','$presu',
			'$objetivo','$areag','$codcoo')";
			//echo $sql;
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
			
			}else
			{
				echo '<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>La comisión ya existe!</strong>
					</div>';
			}
		}
	?>
</body>
</html>
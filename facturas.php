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
	background-image:url('descarga.jpg');
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
	<!--salida-->
		<a href="login.php" style="float:right">Salir</a>
</div>
<div class="container rounded" style="background-color:FEF8F8">
	<!--Parte visual-->
	<h1 class="display-1 mt-4 text-center" style="align:center">Facturación</h1><br>
	<form action="facturas.php" method="POST">
	<!--Label validado segun puesto-->
	<div class="row">
		<div class="form-group col-md-3">		
			<label for="cod"><b><?php $r = ($_SESSION['puesto']=="Coordinador") ? "Código Comisión" : "Código Colaborador"; echo $r; ?></b></label>
			<input type="number" class="form-control" id="cod" name="cod" value="<?php $r = ($_SESSION['puesto']=='Coordinador') ? $_SESSION['codcom'] : $_SESSION['codigo']; echo $r; ?>" readonly>
		</div>	
		<div class="form-group col-md-5">
			<label for="fecha"><b>Fecha consumo</b></label>
			<input type="date" class="form-control" id="fecha" name="fecha" required>
		</div>
	</div>
		<fieldset>
			<legend>Descripción</legend>
			<div class="row">
			<div class="form-group col-md-4">
				<label for="cant"><b>Cantidad</b></label>
				<input type="number" class="form-control" id="cant" name="cant" min="1" max="999999999" placeholder="Cantidad" required>
			</div>	
			<div class="form-group col-md-4">
				<label for="pu"><b>Precio Unitario</b></label>
				<input type="number" id="pu" class="form-control" name="pu" min="1" max="999999999" placeholder="Precio unitario" required>
			</div>	
			<div class="form-group col-md-4">
				<label for="tipo"><b>Tipo de Producto</b></label>
				<input type="text" id="tipo" class="form-control" name="tipo" maxlength="30" placeholder="Tipo de producto" required>
			</div></div>
		</fieldset>
	<div class="row">
		<div class="form-group col-md-3">
			<label for="total"><b>Total Producto</b></label>
			<input type="number" class="form-control" id="total" name="total" min="1" max="999999999" step="0.01" placeholder="Total" required>
		</div>	
		<div class="form-group col-md-3">
			<label for="monto"><b>Monto a Pagar</b></label>
			<input type="number" class="form-control" id="monto" name="monto" min="1" max="999999999" step="0.01" placeholder="Monto a pagar" required>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-12">	
			<input type="submit" class="btn btn-danger form-control" name="btfac" value="Facturar">
		</div>
	</form>
	<?php
	include('conectar.php'); //Conexion a base de datos
		if(isset($_POST["btfac"]))
		{
			$cod = $_POST["cod"]; //codigo de colaborador o comision dependiendo del caso
			//Verificacion de que el preuspuesto no este bloqueado o ya no tiene
			$sql = "SELECT `codigo_colaborador`, `codigo_comision`  FROM `facturas` WHERE `codigo_colaborador`='$cod' OR `codigo_comision`='$cod'";
			$r = $conn->query($sql);
			if($r->num_rows==0) //solo si no esta bloqueado 
			{
				//datos a ingresar
				$fecha = $_POST["fecha"];
				$cant = $_POST["cant"];
				$pu = $_POST["pu"];
				$tipo = $_POST["tipo"];
				$total = $_POST["total"];
				$monto = $_POST["monto"];
				$codigo = $_SESSION["codigo"];
				$codcom = $_SESSION["codcom"];
				if($cod == $codigo) 
				{
				//facturacion docente
					$sql2 = "SELECT `presupuesto` FROM `personal` WHERE `codigo_colaborador`='$cod'";
					$presu = (($conn->query($sql2))->fetch_assoc())["presupuesto"];
					if($monto < $presu)
					{ 
						$p = $presu - $monto;
						$presuactual = "UPDATE `personal` SET `presupuesto`='$p' WHERE `codigo_colaborador`='$cod'";
						$conn->query($presu);
						$sql = "INSERT INTO `facturas`(`codigo_comision`, `codigo_colaborador`, `fecha_consumo`, 
						`cantidad`, `precio_unit`, `tipo_produc`, `total_produc`, `monto`, `estado`) VALUES 
						('$codcom','$codigo','$fecha','$cant','$pu','$tipo','$total','$monto','Autorizado','Bloqueado')";
						echo '<div class="alert alert-succes alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Autorizado!</strong>
					</div>';
						
					} else if($monto == $presu)
					{
						$presuactual = "UPDATE `personal` SET `presupuesto`='0' WHERE `codigo_colaborador`='$cod'";
						$conn->query($presu);
						$sql = "INSERT INTO `facturas`(`codigo_comision`, `codigo_colaborador`, `fecha_consumo`, 
						`cantidad`, `precio_unit`, `tipo_produc`, `total_produc`, `monto`, `estado`) VALUES 
						('$codcom','$codigo','$fecha','$cant','$pu','$tipo','$total','$monto','Autorizado','No bloqueado')";
						echo '<div class="alert alert-succes alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Autorizado!</strong>
					</div>';
					}
					else {
						$sql = "INSERT INTO `facturas`(`codigo_comision`, `codigo_colaborador`, `fecha_consumo`, 
						`cantidad`, `precio_unit`, `tipo_produc`, `total_produc`, `monto`, `estado`) VALUES 
						('$codcom','$codigo','$fecha','$cant','$pu','$tipo','$total','$monto','Cotizacion','Bloqueado')";
						 echo '<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Presupuesto insuficiente! Cotización realizada</strong>
					</div>';
					}
				} else 
				{
				//facturacion coordinador
					$presu = "SELECT `presupuesto` FROM `comisiones` WHERE `codigo_comision`='$cod'";
					$presuoriginal = (($conn->query($presu))->fetch_assoc())["presupuesto"];
					if($monto < $presuoriginal)
					{ 	
						$p = $presuoriginal - $monto;
						$presuactual = "UPDATE `comisiones` SET `presupuesto`='$p' WHERE `codigo_comision`='$cod'";
						$conn->query($presuactual);
						$sql = "INSERT INTO `facturas`(`codigo_comision`, `codigo_colaborador`, `fecha_consumo`, 
						`cantidad`, `precio_unit`, `tipo_produc`, `total_produc`, `monto`, `estado`) VALUES 
						('$codcom','$codigo','$fecha','$cant','$pu','$tipo','$total','$monto','Autorizado','Bloqueado')";
						echo '<div class="alert alert-succes alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Autorizado!</strong>
					</div>';
					} else if($monto == $presuoriginal)
					{
						$presuactual = "UPDATE `comisiones` SET `presupuesto`='0' WHERE `codigo_comision`='$cod'";
						$conn->query($presuactual);
						$sql = "INSERT INTO `facturas`(`codigo_comision`, `codigo_colaborador`, `fecha_consumo`, 
						`cantidad`, `precio_unit`, `tipo_produc`, `total_produc`, `monto`, `estado`) VALUES 
						('$codcom','$codigo','$fecha','$cant','$pu','$tipo','$total','$monto','Autorizado','No bloqueado')";
						echo '<div class="alert alert-succes alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Autorizado!</strong>
					</div>';
					}
					else {
						$sql = "INSERT INTO `facturas`(`codigo_comision`, `codigo_colaborador`, `fecha_consumo`, 
						`cantidad`, `precio_unit`, `tipo_produc`, `total_produc`, `monto`, `estado`) VALUES 
						('$codcom','$codigo','$fecha','$cant','$pu','$tipo','$total','$monto','Cotizacion','Bloqueado')";
						echo '<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Presupuesto insuficiente! Cotización realizada</strong>
					</div>';
					}
				}
				$conn->query($sql);
				echo "<table border='1' style='width%100'class='table table-hover'>
						<thead>	
							<tr>
								<th>Código Colaborador</th>
								<th>Código Comisión</th>
								<th>Fecha de Consumo</th>
								<th>Cantidad</th>
								<th>Precio Unitario</th>
								<th>Tipo de Producto</th>
								<th>Total</th>
								<th>Monto</th>
							</tr>
						</thead>	
							<tr>
								<th>$codcom</th>
								<th>$codigo</th>
								<th>$fecha</th>
								<th>$cant</th>
								<th>$pu</th>
								<th>$tipo</th>
								<th>$total</th>
								<th>$monto</th>
							</tr>
						</table>";
			}else 
			{
				echo '<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Presupuesto bloqueado!</strong>
					</div>';
			}
		}
	?>
</body>
</html>
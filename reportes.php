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
		<!--Opciones del menu-->
		<a href="registro.php" >Registro personal</a>
		<a href="comisiones.php">Ingreso comisiones</a>
		<a href="reportes.php">Reportes</a>
		<!--Salida-->
		<a href="login.php" style="float:right">Salir</a>
	</div>
	
	
<div class="container rounded" style="background-color:FEF8F8">
	<!--Pare visual-->
	<h1 class="display-1 mt-3 text-center" style="align:center">Reportes</h1><br>
	<h4 class="display-4"><small>Reporte Docente</small></h4>
	<table border="1" style="width%100" class="table table-hover">
		<thead style="background-color:#A52B2B"><!--Cabecera de la tabla-->
			<tr>
				<th>Código Colaborador</th>
				<th>Fecha de Consumo</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th>Tipo de Producto</th>
				<th>Total</th>
				<th>Monto</th>
				<th>Transacción</th>
			</tr>
		</thead>
	<?php
		include('conectar.php');//conexion a la tabla
			//reporte docentes
			$sql = "SELECT * FROM `facturas` INNER JOIN personal ON facturas.codigo_colaborador=personal.codigo_colaborador 
			WHERE personal.puesto='Docente' ORDER BY facturas.fecha_consumo ASC";
			$result = $conn->query($sql);
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					//datos
					echo "<tr>
				<td>".$row['codigo_comision']."</td>
				<td>".$row['fecha_consumo']."</td>
				<td>".$row['cantidad']."</td>
				<td>".$row['precio_unit']."</td>
				<td>".$row['tipo_produc']."</td>
				<td>".$row['total_produc']."</td>
				<td>".$row['monto']."</td>
				<td>".$row['transa']."</td>
			</tr>";}
			}
	?>
	</table>
		<br>
	<h4 class="display-4"><small>Reporte Bloqueos</small></h4>

	<table border="1" style="width%100" class="table table-hover">
		<thead style="background-color:#A52B2B"><!--Cabecera tabla-->
			<tr>
				<th>Código Comisión</th>
				<th>Código Colaborador</th>
				<th>Fecha de Consumo</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th>Tipo de Producto</th>
				<th>Total</th>
				<th>Monto</th>
			</tr>
		</thead>
	<?php
		include('conectar.php');//conexion a la tabla
			//reprote bloqueos
			$sql = "SELECT * FROM `facturas` WHERE `estado`='Bloqueado' ORDER BY `codigo_colaborador` ASC";
			$result = $conn->query($sql);
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					//datos
					echo "<tr>
				<td>".$row['codigo_comision']."</td>
				<td>".$row['codigo_colaborador']."</td>
				<td>".$row['fecha_consumo']."</td>
				<td>".$row['cantidad']."</td>
				<td>".$row['precio_unit']."</td>
				<td>".$row['tipo_produc']."</td>
				<td>".$row['total_produc']."</td>
				<td>".$row['monto']."</td>
			</tr>";}
				}
		
	?>
	</table>
	<h4 class="display-4"><small>Reporte Comisión</small></h4>
	<div class="row">
	<div class="form-group col-md-4">
	<!--Las opciones de las comisiones como botones-->
	<form method="POST" action="reportes.php">
		<input type="submit" value="Redes" name="op1" class="btn btn-danger form-control">
	</form></div>
	<div class="form-group col-md-4">
	<form method="POST" action="reportes.php">
		<input type="submit" value="Capacitaciones" name="op2" class="btn btn-danger form-control">
	</form></div>
	<div class="form-group col-md-4">
	<form method="POST" action="reportes.php">
		<input type="submit" value="Proyectos" name="op3" class="btn btn-danger form-control">
	</form></div>
	</div>

	<table border="1" style="width%100" class="table table-hover">
		<thead style="background-color:#A52B2B"><!--Cabecera tabla-->
			<tr>
				<th>Código Comisión</th>
				<th>Fecha de Consumo</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th>Tipo de Producto</th>
				<th>Total</th>
				<th>Monto</th>
				<th>Transacción</th>
				<th>Estado</th>
			</tr>
		</thead>

	<?php
		
		include('conectar.php'); //conexion
			//reporte comisiones
			$sql = "SELECT * FROM `facturas` INNER JOIN comisiones ON facturas.codigo_comision = comisiones.codigo_comision ORDER BY facturas.fecha_consumo ASC";
			$result = $conn->query($sql);
			//Reporte comision de redes
			if (isset($_POST["op1"])){
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					if($row['nombre_comision']=="Redes"){
					echo "<tr>
				<td>".$row['codigo_comision']."</td>
				<td>".$row['fecha_consumo']."</td>
				<td>".$row['cantidad']."</td>
				<td>".$row['precio_unit']."</td>
				<td>".$row['tipo_produc']."</td>
				<td>".$row['total_produc']."</td>
				<td>".$row['monto']."</td>
				<td>".$row['transa']."</td>
				<td>".$row['estado']."</td>
				</tr>";}
				}
			}
		} 
		//Reporte comision capacitaciones
		if (isset($_POST["op2"])){
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					if($row["nombre_comision"]=="Capacitaciones"){
					echo "<tr>
				<td>".$row['codigo_comision']."</td>
				<td>".$row['fecha_consumo']."</td>
				<td>".$row['cantidad']."</td>
				<td>".$row['precio_unit']."</td>
				<td>".$row['tipo_produc']."</td>
				<td>".$row['total_produc']."</td>
				<td>".$row['monto']."</td>
				<td>".$row['transa']."</td>
				<td>".$row['estado']."</td>
				</tr>";}
				}
			}
		}
		//reporte comision Proyecto
		if (isset($_POST["op3"])){
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					if($row["nombre_comision"]=="Proyecto" || $row["nombre_comision"]=="Proyectos"){
					echo "<tr>
				<td>".$row['codigo_comision']."</td>
				<td>".$row['fecha_consumo']."</td>
				<td>".$row['cantidad']."</td>
				<td>".$row['precio_unit']."</td>
				<td>".$row['tipo_produc']."</td>
				<td>".$row['total_produc']."</td>
				<td>".$row['monto']."</td>
				<td>".$row['transa']."</td>
				<td>".$row['estado']."</td>
				</tr>";}
				}
			}
		}
	?>
	</table>
		<br>
	
</body>
</html>
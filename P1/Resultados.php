<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
</head>

<body>
	<?php
	$dbhost = '127.0.0.1';
	$dbuser = 'root';
	$dbpass = '';
	$db = 'p1';
	$port = '3308';
	$conexion = new mysqli($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
	
	$query = $conexion->query("Select * from profesor") or die("Fallo consulta");

	//Valores
	$cProfesor = $_POST['cProfesor'];
	$cEdad = $_POST['cEdad'];
	$profesor = $_POST['profesor'];
	$edad = $_POST['edad'];
	$valorPreguntas = array("0"=> "NS", "1" => "1", "2" => "2", "3" => "3", "4" => "
		4", "5" => "5");
	$valorEdades = array("1" => "<=19", "2" => "20-21", "3" => "21-23", "4" => "
		24-25", "5" => ">25");
	?>
	<h2>Filtros:</h2>
	<form action="Resultados.php" method="post">

		<input type="checkbox" name="cProfesor">
		Profesor: <select name=profesor>
		<?php 
		while ($row = $query->fetch_assoc()):
			echo "<option value=".$row['cod_prof'].">".$row['cod_prof']."</option>";
		endwhile; 
		?>
		</select>
		<br>
		<input type="checkbox" name="cEdad">
		Edad: 
		<select name="edad">
			<?php 
			for($i=1; $i <= count($valorEdades); $i++) {
				echo "<option value=".$i.">".$valorEdades[$i]."</option>";
			} 
			?>
		</select>
		<br>
		<input type="checkbox" name="cSexo">
		Sexo: 
		<select name="sexo">
			<option value="1">Hombre</option>
			<option value="2">Mujer</option>
		</select>
		<br>
						
		<br>
		<input type="submit" name="Buscar" value="Buscar">
	</form>

	<?php

	$nombrePregunta ="Todas";
	$select = "*";
	$where = " where(";
	$wherecond = "false";
	//*Encuesta

	if($cEdad=="on")
	{
		$QEncuesta = "on";
		$tabla = "Encuesta";
		$id_enQuery = "select id_en from ".$tabla;
		if($cEdad=="on")
		{
			if($wherecond == "true")
				$respWhere = $respWhere." and ";
			else
				$wherecond = "true";

			$where = $where."edad = $edad";
		}
		if($wherecond == "true")
			$id_enQuery = $id_enQuery.$where.")";
	}

	//Encuesta

	$nombrePregunta ="Todas";
	$select = "*";
	$where = " where(";
	$wherecond = "false";

	//*Respuesta

	$tabla = "respuesta";
	$Query = "select ".$select." from ".$tabla;

	if($cProfesor == "on"):
		if($wherecond == "true")
			$where = $where." and ";
		else
			$wherecond = "true";
		$where = $where."cod_prof = $profesor";
	endif;

	if($QEncuesta == "on"):
		if($wherecond == "true")
			$where = $where." and ";
		else
			$wherecond = "true";
		$where = $where."id_en in (".$id_enQuery.")";
	endif;

	if($wherecond == "true")
		$Query = $Query.$where.")";

	echo $Query;
	$respuestas = $conexion->query("$Query") or die("Fallo");
	$nrespuestas = $respuestas->num_rows;
	//Respuesta

	$nopciones = 6;

	for($i = 0; $i < $nopciones; $i++)
	{
		$valorOpcion[$i] = 0;
	}

	while($respFila = $respuestas->fetch_assoc()):
		$vectorRespuestas[] = $respFila['resp'];
		if($respFila['resp'] == 0)
			$valorOpcion['0']++;
		elseif($respFila['resp'] == 1)
			$valorOpcion['1']++;
		elseif($respFila['resp'] == 2)
			$valorOpcion['2']++;
		elseif($respFila['resp'] == 3)
			$valorOpcion['3']++;
		elseif($respFila['resp'] == 4)
			$valorOpcion['4']++;
		elseif($respFila['resp'] == 5)
			$valorOpcion['5']++;
		$i++;
	endwhile;
	
	

	$dataPoints = array();

	for($i = 0; $i < $nopciones; $i++)
	{
		$array = array("y"=> $valorOpcion[$i], "label"=> $valorPreguntas[$i]);
		array_push($dataPoints,$array);
	}

	$name = "Pregunta: Todas";
	if($cProfesor == "on"):
		$resp = $conexion->query("select * from profesor where cod_prof = $profesor") or die ("Fallo Profesor");
		$fila = $resp->fetch_assoc();
		$name = $name." - Profesor: ".$fila['nombre'];
	endif;

	if($cEdad == "on")
	{
		$name = $name." - Edad: ".$valorEdades[$edad];
	}
	?>

	<script>
	window.onload = function () {
	 
	var chart = new CanvasJS.Chart("chartContainer", {
		exportEnabled: true,
		animationEnabled: true,
		title:{
			text: "Simple Column Chart with Index Labels"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
	chart.title.set("text", "<?php echo $name ?>");
	}
	</script>

	<div id="chartContainer" style="height: 370px; width: 100%;"></div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<?php
	//media
	$media = 0;
	for($i = 1; $i <= 5; $i++)
	{
		$media +=( $valorOpcion[$i]*$i);
	}
	if($media != 0)
		$media /= $nrespuestas;
	$media = number_format($media,2);
	//mediana
	sort($vectorRespuestas);
	$mediana = $vectorRespuestas[($nrespuestas/2)-1];
	if(($nrespuestas%2)==0)
	{
		$mediana += $vectorRespuestas[($nrespuestas/2)];
		if($mediana != 0)
			$mediana /=2;
	}
	//moda
	$moda = 0;
	$nrepeticiones = 0;
	for($i = 0; $i < $nopciones; $i++)
	{
		if($valorOpcion[$i] > $nrepeticiones)
		{
			$moda = $i;
			$nrepeticiones = $valorOpcion[$i];
		}
	}
	?>
	<h1 align="center">Media: <?php echo $media; ?></h1>
	<h1 align="center">Mediana: <?php echo $mediana; ?></h1>
	<h1 align="center">Moda: <?php echo $moda; ?></h1>
</body>
</html>  
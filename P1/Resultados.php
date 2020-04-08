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
	$cProfesor = $_POST['cProfesor'];
	$cEdad = $_POST['cEdad'];
	$profesor = $_POST['profesor'];
	?>
	<form action="Resultados.php" method="post">

		<input type="checkbox" name="cProfesor">
		Profesor: <select name=profesor>";
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
			<option value="1"><=19</option>
			<option value="2">20-21</option>
			<option value="3">22-23</option>
			<option value="4">24-25</option>
			<option value="5">>25</option>
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
	$respSelect = "*";
	$respQuery = "select ".$respSelect." from respuesta ";
	$respWhere = "where(";
	if($cProfesor == "on"):
		if($wherecond == "true")
			$respWhere = $respWhere." and ";
		else
			$wherecond = "true";
		$respWhere = $respWhere."cod_prof = $profesor";
	endif;
	if($wherecond == "true")
		$respQuery = $respQuery.$respWhere.")";

	$respuestas = $conexion->query("$respQuery") or die("Fallo");

	$nopciones = 6;
	for($i = 0; $i < $nopciones; $i++)
	{
		$valorOpcion[$i] = 0;
	}

	while($respFila = $respuestas->fetch_assoc()):
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
	endwhile;

	$valorPreguntas = array("0"=> "NS", "1" => "1", "2" => "2", "3" => "3", "4" => "
		4", "5" => "5");

	$dataPoints = array();

	for($i = 0; $i < $nopciones; $i++)
	{
		$array = array("y"=> $valorOpcion[$i], "label"=> $valorPreguntas[$i]);
		array_push($dataPoints,$array);
	}

	$name = "Pregunta: Todas";
	if($cProfesor == "on"):
		$resp = $conexion->query("select * from profesor where cod_prof = $profesor");
		$fila = $resp->fetch_assoc();
		$name = $name." - Profesor: ".$fila['nombre'];
	endif;
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
</body>
</html>  
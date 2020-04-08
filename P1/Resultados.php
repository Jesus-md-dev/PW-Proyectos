<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
</head>

<body>
	<?php
	error_reporting(E_ERROR | E_PARSE);
	$dbhost = '127.0.0.1';
	$dbuser = 'root';
	$dbpass = '';
	$db = 'p1';
	$port = '3308';
	$conexion = new mysqli($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");

	//Valores
	//$cPregunta = $_POST['cPregunta'];
	$pregunta = $_POST['pregunta'];

	$cProfesor = $_POST['cProfesor'];
	$profesor = $_POST['profesor'];

	$cEdad = $_POST['cEdad'];
	$edad = $_POST['edad'];
	$valorEdades = array("1" => "<=19", "2" => "20-21", "3" => "21-23", "4" => "
		24-25", "5" => ">25");

	$cSexo = $_POST['cSexo'];
	$sexo = $_POST['sexo'];
	$valorSexo = array("1" => "Hombre", "2" => "Mujer");

	$cAlto = $_POST['cAlto'];
	$alto = $_POST['alto'];
	$valorAlto = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");

	$cBajo = $_POST['cBajo'];
	$bajo = $_POST['bajo'];
	$valorBajo = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");

	$cMatriculado = $_POST['cMatriculado'];
	$matriclado = $_POST['matriclado'];
	$valorMatriculado = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");

	$cExaminado = $_POST['cExaminado'];
	$examinado = $_POST['examinado'];
	$valorExaminado = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");

	$cInteres = $_POST['cInteres'];
	$interes = $_POST['interes'];
	$valorInteres = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");

	$cTutorias = $_POST['cTutorias'];
	$tutorias = $_POST['tutorias'];
	$valorTutorias = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");

	$cDificultad = $_POST['cDificultad'];
	$dificultad = $_POST['dificultad'];
	$valorDificultad = array("1" => "Baja", "2" => "Media", "3" => "Alta", "4" => "Muy alta");

	$cCalificacion = $_POST['cCalificacion'];
	$calificacion = $_POST['calificacion'];
	$valorCalificacion = array("1" => "N.P.", "2" => "Sus.", "3" => "Apro.", "4" => "Not.", "5" => "Sobr.", "6" => "Mat.Hon.");

	$cAsistencia = $_POST['cAsistencia'];
	$asistencia = $_POST['asistencia'];
	$valorAsistencia = array("1" => "Menos 50%", "2" => "Entre 50% y 80%", "3" => "Más de 80%");

	$valorPreguntas = array("0"=> "NS", "1" => "1", "2" => "2", "3" => "3", "4" => "
		4", "5" => "5");
	?>
	<h2>Filtros:</h2>
	<form action="Resultados.php" method="post">

		<!--<input type="checkbox" name="cPregunta">-->
		Pregunta: <select name=pregunta>
		<option value="-1">Todas</option>
		<?php 
		$query = $conexion->query("Select * from pregunta") or die("Fallo consulta");
		while ($row = $query->fetch_assoc()):
			echo "<option value=".$row['cod_preg'].">".$row['enunciado']."</option>";
		endwhile;
		?>
		</select>
		<br>

		<input type="checkbox" name="cProfesor">
		Profesor: <select name=profesor>
		<?php 
		$query = $conexion->query("Select * from profesor") or die("Fallo consulta");
		while ($row = $query->fetch_assoc()):
			echo "<option value=".$row['cod_prof'].">".$row['cod_prof']."</option>";
		endwhile; 
		?>
		</select>
		<br>

		<input type="checkbox" name="cEdad">
		Edad: 
		<select name="edad">
			<?php for($i=1; $i <= count($valorEdades); $i++) {
				echo "<option value=".$i.">".$valorEdades[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cSexo">
		Sexo: 
		<select name="sexo">
			<?php for($i=1; $i <= count($valorSexo); $i++) {
				echo "<option value=".$i.">".$valorSexo[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cAlto">
		Curso más alto:
		<select name="alto">
			<?php for($i=1; $i <= count($valorAlto); $i++) {
				echo "<option value=".$i.">".$valorAlto[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cBajo">
		Curso más bajo:
		<select name="bajo">
			<?php for($i=1; $i <= count($valorBajo); $i++) {
				echo "<option value=".$i.">".$valorBajo[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cMatriculado">
		Veces matriculado:
		<select name="matriclado">
			<?php for($i=1; $i <= count($valorMatriculado); $i++) {
				echo "<option value=".$i.">".$valorMatriculado[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cExaminado">
		Veces examinado:
		<select name="examinado">
			<?php for($i=1; $i <= count($valorExaminado); $i++) {
				echo "<option value=".$i.">".$valorExaminado[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cInteres">
		Interes:
		<select name="interes">
			<?php for($i=1; $i <= count($valorInteres); $i++) {
				echo "<option value=".$i.">".$valorInteres[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cTutorias">
		Uso de Tutorias:
		<select name="tutorias">
			<?php for($i=1; $i <= count($valorTutorias); $i++) {
				echo "<option value=".$i.">".$valorTutorias[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cDificultad">
		Dificultad:
		<select name="dificultad">
			<?php for($i=1; $i <= count($valorDificultad); $i++) {
				echo "<option value=".$i.">".$valorDificultad[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cCalificacion">
		Calificacion esperada:
		<select name="calificacion">
			<?php for($i=1; $i <= count($valorCalificacion); $i++) {
				echo "<option value=".$i.">".$valorCalificacion[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="checkbox" name="cAsistencia">
		Asistencia:
		<select name="asistencia">
			<?php for($i=1; $i <= count($valorAsistencia); $i++) {
				echo "<option value=".$i.">".$valorAsistencia[$i]."</option>";
			} ?>
		</select>
		<br>

		<input type="submit" name="Buscar" value="Buscar">
	</form>

	<?php

	if($pregunta == "-1")
		$nombrePregunta = "Todas";
	else
	{
		$query = $conexion->query("Select * from pregunta where cod_preg = ".$pregunta) or die("Fallo consulta Pregunta");
		$result = $query->fetch_assoc();
		$nombrePregunta = $result['enunciado'];
	}

	$name = "Pregunta: ".$nombrePregunta;

	if($cProfesor == "on"):
		$resp = $conexion->query("select * from profesor where cod_prof = $profesor") or die ("Fallo Profesor");
		$fila = $resp->fetch_assoc();
		$name = $name." | Profesor: ".$fila['nombre'];
	endif;

	$select = "*";
	$where = " where(";
	$wherecond = "false";
	//*Encuesta

	if($cEdad=="on" || $cSexo=="on" || $cAlto == "on" || $cBajo == "on" || $cMatriculado == "on" || $cExaminado == "on"  || $cInteres == "on" || $cTutorias == "on" || $cDificultad == "on" || $cCalificacion == "on" || $cAsistencia == "on")
	{
		$QEncuesta = "on";
		$tabla = "Encuesta";
		$id_enQuery = "select id_en from ".$tabla;

		if($cEdad=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."edad = $edad";
			$name = $name." | Edad: ".$valorEdades[$edad];
		}

		if($cSexo=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."sexo = $sexo";
			$name = $name." | Sexo: ".$valorSexo[$sexo];
		}

		if($cAlto=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."curso_sup = $alto";
			$name = $name." | Curso más alto: ".$valorAlto[$alto];
		}

		if($cBajo=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."curso_inf = $bajo";
			$name = $name." | Curso más bajo: ".$valorBajo[$bajo];
		}

		if($cMatriculado=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."n_matri = $matriclado";
			$name = $name." | Veces matriclado: ".$valorMatriculado[$matriclado];
		}

		if($cExaminado=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."n_exam = $examinado";
			$name = $name." | Veces examinado: ".$valorExaminado[$examinado];
		}

		if($cInteres=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."interes = $interes";
			$name = $name." | Interes: ".$valorInteres[$interes];
		}

		if($cTutorias=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."tutorias = $tutorias";
			$name = $name." | Tutorias: ".$valorTutorias[$tutorias];
		}

		if($cDificultad=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."dificultad = $dificultad";
			$name = $name." | Dificultad: ".$valorDificultad[$dificultad];
		}

		if($cCalificacion=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."calif = $calificacion";
			$name = $name." | Calificacion: ".$valorCalificacion[$calificacion];
		}

		if($cAsistencia=="on")
		{
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."asist = $asistencia";
			$name = $name." | Asistencia: ".$valorAsistencia[$asistencia];
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

	if($pregunta != "-1"):
		if($wherecond == "true")
			$where = $where." and ";
		else
			$wherecond = "true";
		$where = $where."cod_preg = $pregunta";
	endif;

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